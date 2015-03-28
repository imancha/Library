<?php namespace App\Http\Controllers\Admin;

use App\Model;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BorrowController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$borrows = Model\Borrow::orderBy('created_at','desc')->paginate(15);

		return view('admin.borrow.index', compact('borrows'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$members = Model\Member::all(['members.id']);
		$books = Model\Book::all(['books.id']);
		$borrow = Model\Borrow::orderBy('created_at','desc')->first();

		return view('admin.borrow.create',compact('members','books','borrow'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\CreateBorrowRequest $request)
	{
		$member = Model\Member::where('id','=',trim(strip_tags($request->input('id'))))->first();
		$book = Model\Book::where('id','=',trim(strip_tags($request->input('kode'))))->first();

		Model\Borrow::create([
			'id'	=>	trim(strip_tags($request->input('idp'))),
			'tanggal_pinjam'	=>	new \DateTime,
			'member_id'	=>	$member->id,
			'book_id'		=>	$book->id,
		]);

		return \Redirect::route('admin.borrow.create')->with('message', (trim(strip_tags($request->input('idp')))).' berhasil disimpan.');
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
