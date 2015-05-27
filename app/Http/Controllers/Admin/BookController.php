<?php namespace App\Http\Controllers\Admin;

use Auth;
use Excel;
use Validator;
use App\Model\Author;
use App\Model\Book;
use App\Model\BookAuthor;
use App\Model\Borrow;
use App\Model\File;
use App\Model\Publisher;
use App\Model\Rack;
use App\Model\Subject;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$borrows = Borrow::where('status','like','%pinjam%')->get();

		if($request->has('q')){
			$q = trim(strip_tags($request->input('q')));
			$books = Book::where('id','like','%'.$q.'%')->orWhere('judul','like','%'.$q.'%')->orWhere('tahun','like','%'.$q.'%')->orWhere('jenis','like','%'.$q.'%')->orWhere('tanggal_masuk','like','%'.$q.'%')->orWhere('keterangan','like','%'.$q.'%')->orWhereIn('id',BookAuthor::whereIn('author_id',Author::where('nama','like','%'.$q.'%')->get(['authors.id'])->toArray())->get(['book_id'])->toArray())->orWhereIn('publisher_id',Publisher::where('nama','like','%'.$q.'%')->get(['publishers.id'])->toArray())->orWhereIn('subject_id',Subject::where('nama','like','%'.$q.'%')->get(['subjects.id'])->toArray())->orWhereIn('rack_id',Rack::where('nama','like','%'.$q.'%')->get(['racks.id'])->toArray())->orWhereIn('id',Borrow::where('status','like','%'.$q.'%')->get(['borrows.book_id'])->toArray())->orderBy('tanggal_masuk','desc')->paginate(10);
			$books->setPath('../admin/book^q='.$q);
		}else{
			$books = Book::orderBy('tanggal_masuk','desc')->paginate(10);
			$books->setPath('../admin/book');
		}

		return view(Auth::user()->status.'.book.index', compact('borrows','books'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$publishers = Publisher::orderBy('nama', 'asc')->get(['publishers.nama']);
		$subjects = Subject::orderBy('nama', 'asc')->get(['subjects.nama']);
		$racks = Rack::orderBy('nama', 'asc')->get(['racks.nama']);
		$asli = Book::where('jenis','=','asli')->orderBy('tanggal_masuk','desc')->first();
		$pkl = Book::where('jenis','=','pkl')->orderBy('tanggal_masuk','desc')->first();

		if(count($asli) > 0){
			$asli = remove_alpha($asli->id);
			do{
				empty(Book::find(++$asli)) ? $next = false : $next = true;
			}while($next);
		}else{
			$asli = 1;
		}

		if(count($pkl) > 0){
			$pkl = remove_alpha($pkl->id);
			do{
				empty(Book::find(++$pkl.'P')) ? $next = false : $next = true;
			}while($next);
		}else{
			$pkl = 1;
		}

		return view(Auth::user()->status.'.book.create', compact('publishers','subjects','racks','asli','pkl'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$rules = [
			'jenis'				=>	'required',
			'id'					=>	'required|alpha_num|unique:books,id',
			'judul'				=>	'required|min:3|max:255',
			'pengarang'		=>	'required|min:3|max:255',
			'penerbit'		=>	'required|min:3|max:255',
			'tahun'				=>	'required|digits:4',
			'subyek'			=>	'required|min:3',
			'rak'					=>	'required|min:3',
			'keterangan'	=>	'min:3|max:255',
			'file'				=>	'mimes:pdf,doc,docx,ppt,pptx,zip,rar',
		];

		$validator = Validator::make($request->all(), $rules);

		$validator->after(function($validator) use($request){
			if(is_numeric($request->input('jenis')) && !is_numeric($request->input('id')))
				$validator->errors()->add('id', 'The kode buku must be a number.');
			elseif(!is_numeric($request->input('jenis')) && (is_numeric($request->input('id')) || !is_numeric(substr($request->input('id'),0,-1)) || (substr($request->input('id'),-1) != 'P')))
				$validator->errors()->add('id', 'The kode buku is invalid.');
		});

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator->messages());
		}else{
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
				'tahun'					=>	trim(strip_tags($request->input('tahun'))),
				'jenis'					=>	trim(strip_tags(is_numeric($request->input('jenis')) ? 'asli' : 'pkl')),
				'tanggal_masuk'	=>	new \DateTime,
				'keterangan'		=>	trim(strip_tags($request->input('keterangan'))),
				'publisher_id'	=>	$publisher->id,
				'subject_id'		=>	$subject->id,
				'rack_id'				=>	$rack->id,
			]);

			foreach(explode(',',$request->input('pengarang')) as $value){
				$author = Author::firstOrCreate([
					'nama'	=>	trim(strip_tags($value)),
				]);

				BookAuthor::firstOrCreate([
					'book_id'		=>	trim(strip_tags($request->input('id'))),
					'author_id'	=>	$author->id,
				]);
			}

			if($request->hasFile('file')){
				$path = public_path('files/');
				$name = trim(strip_tags($request->input('id'))).' - '.trim(strip_tags($request->input('judul')));
				$mime = trim(strip_tags($request->file('file')->getClientOriginalExtension()));
				$size = $request->file('file')->getSize();
				$file = $path.$name.'.'.$mime;

				if(\File::exists($file)) \File::delete($file);

				if($request->file('file')->move($path,$name.'.'.$mime)){
					File::create([
						'book_id'		=>	trim(strip_tags($request->input('id'))),
						'mime'			=>	strtolower($mime),
						'size'			=>	humanFileSize($size),
						'sha1sum'		=>	sha1_file($file),
					]);
				}else{
					return redirect()->back()->withInput()->withErrors('Error uploading file.');
				}
			}

			return redirect()->action('Admin\BookController@create')->withMessage(trim(strip_tags($request->input('id'))).' - '.trim(strip_tags($request->input('judul'))).' berhasil disimpan.');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
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
		$publishers = Publisher::orderBy('nama', 'asc')->get(['publishers.nama']);
		$subjects = Subject::orderBy('nama', 'asc')->get(['subjects.nama']);
		$racks = Rack::orderBy('nama', 'asc')->get(['racks.nama']);
		$asli = Book::where('jenis','=','asli')->orderBy('tanggal_masuk','desc')->first();
		$pkl = Book::where('jenis','=','pkl')->orderBy('tanggal_masuk','desc')->first();

		if(count($asli) > 0){
			$asli = remove_alpha($asli->id);
			do{
				empty(Book::find(++$asli)) ? $next = false : $next = true;
			}while($next);
		}else{
			$asli = 1;
		}

		if(count($pkl) > 0){
			$pkl = remove_alpha($pkl->id);
			do{
				empty(Book::find(++$pkl.'P')) ? $next = false : $next = true;
			}while($next);
		}else{
			$pkl = 1;
		}

		return view(Auth::user()->status.'.book.edit', compact('book','publishers','subjects','racks','asli','pkl'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$rules = [
			'jenis'				=>	'required',
			'id'					=>	'required|alpha_num',
			'judul'				=>	'required|min:3|max:255',
			'pengarang'		=>	'required|min:3|max:255',
			'penerbit'		=>	'required|min:3|max:255',
			'tahun'				=>	'required|digits:4',
			'subyek'			=>	'required|min:3',
			'rak'					=>	'required|min:3',
			'keterangan'	=>	'min:3|max:255',
			'file'				=>	'mimes:pdf,doc,docx,ppt,pptx,zip,rar',
		];

		$validator = Validator::make($request->all(), $rules);

		$validator->after(function($validator) use($request){
			if(is_numeric($request->input('jenis')) && !is_numeric($request->input('id')))
				$validator->errors()->add('id', 'The kode buku field must be numeric.');
			elseif(!is_numeric($request->input('jenis')) && (is_numeric($request->input('id')) || !is_numeric(substr($request->input('id'),0,-1)) || (substr($request->input('id'),-1) != 'P')))
				$validator->errors()->add('id', 'The kode buku field is invalid.');
		});

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator->messages());
		}else{
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
			$book->tahun = trim(strip_tags($request->input('tahun')));
			$book->jenis = trim(strip_tags(is_numeric($request->input('jenis')) ? 'asli' : 'pkl'));
			$book->keterangan = trim(strip_tags($request->input('keterangan')));
			$book->publisher_id = $publisher->id;
			$book->subject_id = $subject->id;
			$book->rack_id = $rack->id;
			$book->save();

			BookAuthor::where('book_id','=',$id)->delete();

			foreach(explode(',',$request->input('pengarang')) as $value){
				$author = Author::firstOrCreate([
					'nama'	=>	trim(strip_tags($value)),
				]);

				BookAuthor::create([
					'book_id'		=>	$book->id,
					'author_id'	=>	$author->id,
				]);
			}

			if($request->hasFile('file')){
				$path = public_path('files/');
				$name = trim(strip_tags($request->input('id'))).' - '.trim(strip_tags($request->input('judul')));
				$mime = trim(strip_tags($request->file('file')->getClientOriginalExtension()));
				$size = $request->file('file')->getSize();
				$file = $path.$name.'.'.$mime;

				if(\File::exists($file)) \File::delete($file);

				if($request->file('file')->move($path,$name.'.'.$mime)){
					$files = File::findOrNew($id);
					$files->book_id = $book->id;
					$files->mime = strtolower($mime);
					$files->size = humanFileSize($size);
					$files->sha1sum = sha1_file($file);
					$files->save();
				}else{
					return redirect()->back()->withInput()->withErrors('Error uploading file');
				}
			}

			return redirect()->action('Admin\BookController@index')->withMessage(trim(strip_tags($request->input('id'))).' - '.trim(strip_tags($request->input('judul'))).' berhasil disimpan.');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		$book = Book::find($id);
		$file = File::find($id);
		$auth = $book->author[0]->id;
		$book->delete();

		if(count(Book::where('publisher_id','=',$book->publisher_id)->get()) == 0)
			Publisher::where('id','=',$book->publisher_id)->delete();
		if(count(Book::where('subject_id','=',$book->subject_id)->get()) == 0)
			Subject::where('id','=',$book->subject_id)->delete();
		if(count(Book::where('rack_id','=',$book->rack_id)->get()) == 0)
			Rack::where('id','=',$book->rack_id)->delete();
		if(count(BookAuthor::where('author_id','=',$auth)->get()) == 0)
			Author::where('id','=',$auth)->delete();
		if(!empty($file)){
			if(\File::exists(public_path('files/'.$book->id.' - '.$book->judul.'.'.$file->mime)))
				\File::delete(public_path('files/'.$book->id.' - '.$book->judul.'.'.$file->mime));
			$file->delete();
		}

		return redirect()->back()->withMessage($request->input('id').' - '.$request->input('judul').' berhasil dihapus.');
	}

	public function export($type)
	{
		set_time_limit(500);
		ini_set('memory_limit', '500M');
		\PHPExcel_Settings::setCacheStorageMethod(\PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp, ['memoryCacheSize' => '256M']);

		$asli = Book::where('jenis','=','asli')->orderBy('tanggal_masuk','asc')->get();
		$pkl = Book::where('jenis','=','pkl')->orderBy('tanggal_masuk','asc')->get();

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
					$sheet->row($row, ['KODE BUKU','JUDUL BUKU','PENGARANG','PENERBIT','TAHUN','SUBYEK','RAK','TANGGAL MASUK','KETERANGAN']);
					foreach($asli as $book){
						$authors = [];
						foreach($book->author as $author) $authors[] = $author->nama;
						$sheet->row(++$row, [
							$book->id,
							$book->judul,
							implode(', ',$authors),
							$book->publisher->nama,
							$book->tahun,
							$book->subject->nama,
							$book->rack->nama,
							$book->tanggal_masuk,
							$book->keterangan,
						]);
					}
				});
				$excel->sheet('PKL', function($sheet) use($pkl){
					$row = 1;
					$sheet->freezeFirstRow();
					$sheet->setFontFamily('Sans Serif');
					$sheet->row($row, ['KODE BUKU','JUDUL BUKU','PENGARANG','PENERBIT','TAHUN','SUBYEK','RAK','TANGGAL MASUK','KETERANGAN']);
					foreach($pkl as $book){
						$authors = [];
						foreach($book->author as $author) $authors[] = $author->nama;
						$sheet->row(++$row, [
							$book->id,
							$book->judul,
							implode(', ',$authors),
							$book->publisher->nama,
							$book->tahun,
							$book->subject->nama,
							$book->rack->nama,
							$book->tanggal_masuk,
							$book->keterangan,
						]);
					}
				});
			})->export($type);
		}
	}

}
