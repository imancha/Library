<?php namespace App\Http\Controllers\Admin;

use Redirect;
use App\Model\Author;
use App\Model\Book;
use App\Model\BookAuthor;
use App\Model\Borrow;
use App\Model\File;
use App\Model\Member;
use App\Model\Publisher;
use App\Model\Rack;
use App\Model\Subject;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TrashController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if($id == 'book')
			$result = Book::onlyTrashed()->orderBy('deleted_at','desc')->paginate(15);
		elseif($id == 'member')
			$result = Member::onlyTrashed()->orderBy('deleted_at','desc')->paginate(15);
		elseif($id == 'borrow') $result = Borrow::onlyTrashed()->orderBy('deleted_at','desc')->paginate(15);

		return view('admin.trash.'.$id, compact('result'));
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
		$id = explode('-',$id);

		if($id[0] == 'book')
			$result = Book::onlyTrashed()->where('id','=',$id[1])->restore();
		elseif($id[0] == 'member')
			$result = Member::onlyTrashed()->where('id','=',$id[1])->restore();

		$borrows = Borrow::onlyTrashed()->where($id[0].'_id','=',$id[1])->get();
		$restore = true;

		foreach($borrows as $borrow)
		{
			if((empty($borrow->book->id) || empty($borrow->member->id)))
			{
				$restore=false;
				break;
			}
		}

		if($restore) Borrow::onlyTrashed()->where($id[0].'_id','=',$id[1])->restore();

		return Redirect::back()->with('message', $id[1].' berhasil disimpan.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$id = explode('-',$id);

		if($id[0] == 'book')
		{
			$book = Book::onlyTrashed()->find($id[1]);
			$file = File::onlyTrashed()->find($id[1]);
			$auth = $book->author[0]->id;
			$book->forceDelete();

			if(count(Book::withTrashed()->where('publisher_id','=',$book->publisher_id)->get()) == 0)
				Publisher::where('id','=',$book->publisher_id)->forceDelete();
			if(count(Book::withTrashed()->where('subject_id','=',$book->subject_id)->get()) == 0)
				Subject::where('id','=',$book->subject_id)->forceDelete();
			if(count(Book::withTrashed()->where('rack_id','=',$book->rack_id)->get()) == 0)
				Rack::where('id','=',$book->rack_id)->forceDelete();
			if(count(BookAuthor::where('author_id','=',$auth)->get()) == 0)
				Author::where('id','=',$auth)->forceDelete();
			if(!empty($file))
				if(\File::exists(public_path('files/').$file->filename.'.'.$file->mime))
					\File::delete(public_path('files/').$file->filename.'.'.$file->mime);
		}elseif($id[0] == 'member'){
			$result = Member::onlyTrashed()->where('id','=',$id[1])->forceDelete();
		}

		return Redirect::back()->with('message', $id[1].' berhasil dihapus.');
	}

}
