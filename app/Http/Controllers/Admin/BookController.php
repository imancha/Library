<?php namespace App\Http\Controllers\Admin;

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
				if(\File::exists($file)){
					\File::delete($file);
				}
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

}
