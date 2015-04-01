<?php namespace App\Http\Controllers\Admin;

use Excel;
use PDF;
use Redirect;
use App\Model\Author;
use App\Model\Book;
use App\Model\BookAuthor;
use App\Model\File;
use App\Model\Publisher;
use App\Model\Rack;
use App\Model\Subject;
use App\Http\Requests\CreateBookRequest;
use App\Http\Controllers\Controller;

class BookController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$books = Book::orderBy('created_at','desc')->paginate(15);
		$books->setPath('../admin/book');

		return view('admin.book.index', compact('books'));
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
		$asli = Book::where('jenis','=','ASLI')->orderBy('created_at','desc')->first();
		$pkl = Book::where('jenis','=','PKL')->orderBy('created_at','desc')->first();

		if(count($asli) > 0)
		{
			$next = true;
			$asli = $asli->id;
			do
			{
				if(count(Book::find(++$asli)) == 0) $next = false;
			}while($next);
		}else{
			$asli = 1;
		}

		if(count($pkl) > 0)
		{
			$next = true;
			$pkl = substr($pkl->id,0,strlen($pkl->id)-1);
			do
			{
				if(count(Book::find(++$pkl.'P')) == 0) $next = false;
			}while($next);
		}else{
			$pkl = 1;
		}

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
			'jenis'					=>	trim(strip_tags(is_numeric($request->input('jenis')) ? 'ASLI' : 'PKL')),
			'tanggal_masuk'	=>	trim(strip_tags(implode('-',array_reverse(explode('/',$request->input('tanggal')))))),
			'keterangan'		=>	trim(strip_tags($request->input('keterangan'))),
			'publisher_id'	=>	$publisher->id,
			'subject_id'		=>	$subject->id,
			'rack_id'				=>	$rack->id,
		]);

		foreach(explode('/',$request->input('pengarang')) as $value)
		{
			$author = Author::firstOrCreate([
				'nama'	=>	trim(strip_tags($value)),
			]);

			BookAuthor::firstOrCreate([
				'book_id'		=>	trim(strip_tags($request->input('id'))),
				'author_id'	=>	$author->id,
			]);
		}

		if(!is_numeric($request->input('jenis')))
		{
			if($request->hasFile('file'))
			{
				$path = public_path('files/');
				$filename = (trim(strip_tags($request->input('id')))).' - '.(trim(strip_tags($request->input('judul')))).'.'.($request->file('file')->getClientOriginalExtension());
				$file = $path.$filename;

				if(\File::exists($file)) \File::delete($file);

				if($request->file('file')->move($path,$filename))
				{
					File::create([
						'book_id'		=>	trim(strip_tags($request->input('id'))),
						'filename'	=>	$filename,
						'sha1sum'		=>	sha1_file($file),
					]);
				}
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
		$books = Book::where('jenis','=',strtoupper($jenis))->orderBy('created_at','desc')->paginate(15);
		$books->setPath('../book/'.$jenis);

		return view('admin.book.index', compact('books'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function export($type)
	{
		set_time_limit (500);
		ini_set('memory_limit', '500M');
		\PHPExcel_Settings::setCacheStorageMethod(\PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp, ['memoryCacheSize' => '256M']);

		$books = Book::orderBy('created_at','asc')->get();

		if($type == 'xlsx'){
			Excel::create('['.date('Y.m.d H.m.s').'] Data Buku', function($excel) use($books){
				$excel->setTitle('Data Buku');
				$excel->setCreator('Perpustakaan PT. INTI')->setCompany('PT. INTI');
				$excel->setDescription('Data Buku Perpustakaan PT. INTI');
				$excel->setlastModifiedBy('Perpustakaan PT. INTI');
				$excel->sheet('Buku', function($sheet) use($books){
					$row = 1;
					$sheet->freezeFirstRow();
					$sheet->setFontFamily('Sans Serif');
					$sheet->row($row, ['KODE BUKU','JUDUL BUKU','PENGARANG','PENERBIT','EDISI','JENIS','SUBYEK','RAK','TANGGAL MASUK','KETERANGAN']);
					foreach($books as $book)
					{
						$authors = [];
						foreach($book->author as $author) $authors[] = $author->nama;
						$sheet->row(++$row, [
							$book->id,
							$book->judul,
							implode(', ',$authors),
							$book->publisher->nama,
							$book->edisi,
							$book->jenis,
							$book->subject->nama,
							$book->rack->nama,
							implode('-',array_reverse(explode('-',$book->tanggal_masuk))),
							$book->keterangan,
						]);
					}
				});
			})->export($type);
		}elseif($type == 'pdf'){
			$pdf = PDF::loadView('admin.book.export', compact('books'));
			return $pdf->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->download('['.date('Y.m.d H.m.s').'] Koleksi Buku.pdf');
		}
	}

}
