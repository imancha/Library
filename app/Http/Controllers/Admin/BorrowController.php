<?php namespace App\Http\Controllers\Admin;

use Redirect;
use App\Model\Book;
use App\Model\Borrow;
use App\Model\Member;
use App\Http\Requests\UpdateBorrowRequest;
use App\Http\Controllers\Controller;

class BorrowController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$borrows = Borrow::orderBy('created_at','desc')->paginate(15);

		return view('admin.borrow.index', compact('borrows'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$members = Member::all(['members.id']);
		$books = Book::whereNotIn('id', function($query){
			$query->select('book_id')->from(with(new Borrow)->getTable())->where('status','=','Dipinjam');
		})->get(['books.id']);
		$borrow = Borrow::orderBy('created_at','desc')->first();

		return view('admin.borrow.create',compact('members','books','borrow'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateBorrowRequest $request)
	{
		$member = Member::where('id','=',trim(strip_tags($request->input('id'))))->first();
		$book = Book::where('id','=',trim(strip_tags($request->input('kode'))))->first();

		Borrow::create([
			'id'	=>	trim(strip_tags($request->input('idp'))),
			'tanggal_pinjam'	=>	new \DateTime,
			'member_id'	=>	$member->id,
			'book_id'		=>	$book->id,
		]);

		return Redirect::route('admin.borrow.create')->with('message', (trim(strip_tags($request->input('idp')))).' berhasil disimpan.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($status)
	{
		$borrows = Borrow::where('status','like','%'.$status.'%')->orderBy('created_at','desc')->paginate(15);

		return view('admin.borrow.index', compact('borrows'));
	}

	public function patch()
	{
		$borrows = Borrow::where('status','=','Dipinjam')->get(['borrows.id']);

		return view('admin.borrow.patch',compact('borrows'));
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
	public function update(UpdateBorrowRequest $request)
	{
		$borrow = Borrow::find($request->input('idp'));
		$borrow->tanggal_kembali = new \DateTime;
		$borrow->status = 'Dikembalikan';
		$borrow->save();

		return Redirect::route('admin.borrow.return')->with('message', (trim(strip_tags($request->input('idp')))).' berhasil disimpan.');
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
