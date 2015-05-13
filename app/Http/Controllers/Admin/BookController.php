<?php namespace App\Http\Controllers\Admin;

use Excel;
use Redirect;
use App\Model\Author;
use App\Model\Book;
use App\Model\BookAuthor;
use App\Model\Borrow;
use App\Model\File;
use App\Model\Publisher;
use App\Model\Rack;
use App\Model\Subject;
use App\Http\Requests;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\EditBookRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BookController extends Controller {

	private $perpage = 10;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$borrows = Borrow::where('status','like','%pinjam%')->get();
		if($request->has('q'))
		{
			$q = $request->input('q');
			$books = Book::where('id','like','%'.$q.'%')->orWhere('judul','like','%'.$q.'%')->orWhere('edisi','like','%'.$q.'%')->orWhere('jenis','like','%'.$q.'%')->orWhereIn('id',BookAuthor::whereIn('author_id',Author::where('nama','like','%'.$q.'%')->get(['authors.id'])->toArray())->get(['book_id'])->toArray())->orWhereIn('publisher_id',Publisher::where('nama','like','%'.$q.'%')->get(['publishers.id'])->toArray())->orWhereIn('subject_id',Subject::where('nama','like','%'.$q.'%')->get(['subjects.id'])->toArray())->orWhereIn('rack_id',Rack::where('nama','like','%'.$q.'%')->get(['racks.id'])->toArray())->orWhereIn('id',Borrow::where('status','like','%'.$q.'%')->get(['borrows.book_id'])->toArray())->orderBy('created_at','desc')->paginate($this->perpage);
			$books->setPath('../admin/book^q='.$q);
		}else{
			$books = Book::orderBy('created_at','desc')->paginate($this->perpage);
			$books->setPath('../admin/book');
		}

		return view('admin.book.index', compact('borrows','books'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$publishers = Publisher::orderBy('created_at', 'desc')->get(['publishers.nama']);
		$subjects = Subject::orderBy('created_at', 'desc')->get(['subjects.nama']);
		$racks = Rack::orderBy('created_at', 'desc')->get(['racks.nama']);
		$asli = $this->original();
		$pkl = $this->research();

		return view('admin.book.create', compact('publishers','subjects','racks','asli','pkl'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateBookRequest $request)
	{
		$publisher = Publisher::firstOrCreate([
			'nama'	=>	trim(strip_tags($request->input('penerbit'))),
		]);

		$subject = Subject::firstOrCreate([
			'nama'	=>	trim(strip_tags($request->input('subyek'))),
		]);

		$rack = Rack::firstOrCreate([
			'nama'	=>	trim(strip_tags($request->input('rak'))),
		]);

		$book = Book::create([
			'id'						=>	trim(strip_tags($request->input('id'))),
			'judul'					=>	trim(strip_tags($request->input('judul'))),
			'edisi'					=>	trim(strip_tags($request->input('edisi'))),
			'jenis'					=>	trim(strip_tags(is_numeric($request->input('jenis')) ? 'asli' : 'pkl')),
			'tanggal_masuk'	=>	new \DateTime,
			'keterangan'		=>	trim(strip_tags($request->input('keterangan'))),
			'publisher_id'	=>	$publisher->id,
			'subject_id'		=>	$subject->id,
			'rack_id'				=>	$rack->id,
		]);

		foreach(explode(',',$request->input('pengarang')) as $value)
		{
			$author = Author::firstOrCreate([
				'nama'	=>	trim(strip_tags($value)),
			]);

			BookAuthor::firstOrCreate([
				'book_id'		=>	trim(strip_tags($request->input('id'))),
				'author_id'	=>	$author->id,
			]);
		}

		if($request->hasFile('file'))
		{
			$path = public_path('files/');
			$name = trim(strip_tags($request->input('id'))).' - '.trim(strip_tags($request->input('judul')));
			$mime = $request->file('file')->getClientOriginalExtension();
			$size = $request->file('file')->getSize();
			$file = $path.$name.'.'.$mime;

			if(\File::exists($file)) \File::delete($file);

			if($request->file('file')->move($path,$name.'.'.$mime))
			{
				File::create([
					'book_id'		=>	trim(strip_tags($request->input('id'))),
					'mime'			=>	strtolower($mime),
					'size'			=>	humanFileSize($size),
					'sha1sum'		=>	sha1_file($file),
				]);
			}
		}

		return Redirect::route('admin.book.create')->with('message', (trim(strip_tags($request->input('id')))).' - '.(trim(strip_tags($request->input('judul')))).' berhasil disimpan.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($jenis)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$book = Book::find($id);
		$publishers = Publisher::orderBy('created_at', 'desc')->get(['publishers.nama']);
		$subjects = Subject::orderBy('created_at', 'desc')->get(['subjects.nama']);
		$racks = Rack::orderBy('created_at', 'desc')->get(['racks.nama']);
		$asli = $this->original();
		$pkl = $this->research();

		return view('admin.book.edit', compact('book','publishers','subjects','racks','asli','pkl'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EditBookRequest $request, $id)
	{
		$book = Book::find($id);

		$publisher = Publisher::firstOrCreate([
			'nama'	=>	trim(strip_tags($request->input('penerbit'))),
		]);

		$subject = Subject::firstOrCreate([
			'nama'	=>	trim(strip_tags($request->input('subyek'))),
		]);

		$rack = Rack::firstOrCreate([
			'nama'	=>	trim(strip_tags($request->input('rak'))),
		]);

		$book->id = trim(strip_tags($request->input('id')));
		$book->judul = trim(strip_tags($request->input('judul')));
		$book->edisi = trim(strip_tags($request->input('edisi')));
		$book->jenis = trim(strip_tags(is_numeric($request->input('jenis')) ? 'asli' : 'pkl'));
		$book->keterangan = trim(strip_tags($request->input('keterangan')));
		$book->publisher_id = $publisher->id;
		$book->subject_id = $subject->id;
		$book->rack_id = $rack->id;
		$book->save();

		BookAuthor::where('book_id','=',$id)->forceDelete();

		foreach(explode(',',$request->input('pengarang')) as $value)
		{
			$author = Author::firstOrCreate([
				'nama'	=>	trim(strip_tags($value)),
			]);

			BookAuthor::create([
				'book_id'		=>	$book->id,
				'author_id'	=>	$author->id,
			]);
		}

		if($request->hasFile('file'))
		{
			$path = public_path('files/');
			$name = trim(strip_tags($request->input('id'))).' - '.trim(strip_tags($request->input('judul')));
			$mime = $request->file('file')->getClientOriginalExtension();
			$size = $request->file('file')->getSize();
			$file = $path.$name.'.'.$mime;

			if(\File::exists($file)) \File::delete($file);

			if($request->file('file')->move($path,$name.'.'.$mime))
			{
				$files = File::find($id);

				if(empty($files)) $files = new File;

				$files->book_id = $book->id;
				$files->mime = strtolower($mime);
				$files->size = humanFileSize($size);
				$files->sha1sum = sha1_file($file);
				$files->save();
			}
		}

		return Redirect::route('admin.book.index')->with('message', (trim(strip_tags($request->input('id')))).' - '.(trim(strip_tags($request->input('judul')))).' berhasil disimpan.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		Book::where('id','=',$id)->delete();
		Borrow::where('book_id','=',$id)->delete();
		File::where('book_id','=',$id)->delete();

		return Redirect::back()->with('message', $request->input('id').' - '.$request->input('judul').' berhasil dihapus.');
	}

	public function export($type)
	{
		set_time_limit(500);
		ini_set('memory_limit', '500M');
		\PHPExcel_Settings::setCacheStorageMethod(\PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp, ['memoryCacheSize' => '256M']);

		$asli = Book::where('jenis','=','asli')->orderBy('created_at','asc')->get();
		$pkl = Book::where('jenis','=','pkl')->orderBy('created_at','asc')->get();

		if($type == 'xls'){
			Excel::create('['.date('Y.m.d H.m.s').'] Data Buku Perpustakaan INTI', function($excel) use($asli,$pkl){
				$excel->setTitle('Data Buku Perpustakaan INTI');
				$excel->setCreator('Perpustakaan INTI')->setCompany('PT. INTI');
				$excel->setDescription('Data Buku Perpustakaan INTI');
				$excel->setlastModifiedBy('Perpustakaan INTI');
				$excel->sheet('ASLI', function($sheet) use($asli){
					$row = 1;
					$sheet->freezeFirstRow();
					$sheet->setFontFamily('Sans Serif');
					$sheet->row($row, ['KODE BUKU','JUDUL BUKU','PENGARANG','PENERBIT','EDISI','SUBYEK','RAK','TANGGAL MASUK','KETERANGAN']);
					foreach($asli as $book){
						$authors = [];
						foreach($book->author as $author) $authors[] = $author->nama;
						$sheet->row(++$row, [
							$book->id,
							$book->judul,
							implode(', ',$authors),
							$book->publisher->nama,
							$book->edisi,
							$book->subject->nama,
							$book->rack->nama,
							implode('-',array_reverse(explode('-',$book->tanggal_masuk))),
							$book->keterangan,
						]);
					}
				});
				$excel->sheet('PKL', function($sheet) use($pkl){
					$row = 1;
					$sheet->freezeFirstRow();
					$sheet->setFontFamily('Sans Serif');
					$sheet->row($row, ['KODE BUKU','JUDUL BUKU','PENGARANG','PENERBIT','EDISI','SUBYEK','RAK','TANGGAL MASUK','KETERANGAN']);
					foreach($pkl as $book){
						$authors = [];
						foreach($book->author as $author) $authors[] = $author->nama;
						$sheet->row(++$row, [
							$book->id,
							$book->judul,
							implode(', ',$authors),
							$book->publisher->nama,
							$book->edisi,
							$book->subject->nama,
							$book->rack->nama,
							implode('-',array_reverse(explode('-',$book->tanggal_masuk))),
							$book->keterangan,
						]);
					}
				});
			})->export($type);
		}
	}

	public function original()
	{
		$asli = Book::where('jenis','=','asli')->orderBy('created_at','desc')->first();

		if(count($asli) > 0)
		{
			$asli = remove_alpha($asli->id);
			do
				empty(Book::withTrashed()->find(++$asli)) ? $next = false : $next = true;
			while($next);
		}else{
			$asli = 1;
		}

		return $asli;
	}

	public function research()
	{
		$pkl = Book::where('jenis','=','pkl')->orderBy('created_at','desc')->first();

		if(count($pkl) > 0)
		{
			$pkl = remove_alpha($pkl->id);
			do
				empty(Book::withTrashed()->find(++$pkl.'P')) ? $next = false : $next = true;
			while($next);
		}else{
			$pkl = 1;
		}

		return $pkl;
	}

}
