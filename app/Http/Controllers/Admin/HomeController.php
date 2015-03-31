<?php namespace App\Http\Controllers\Admin;

use Response;
use Request;
use App\Model\Book;
use App\Model\Borrow;
use App\Model\Member;
use App\Http\Controllers\Controller;

class HomeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$books = Book::count();
		$asli = Book::where('jenis','=','asli')->count();
		$pkl = Book::where('jenis','=','pkl')->count();
		$members = Member::count();
		$karyawan = Member::where('jenis_anggota','=','Karyawan')->count();
		$nonkaryawan = Member::where('jenis_anggota','=','Non-Karyawan')->count();

		return view('admin.home', compact('books','asli','pkl','members','karyawan','nonkaryawan'));
	}

	public function lockscreen()
	{
		return view('auth.lockscreen');
	}

	public function postBook()
	{
		$book = Book::whereNotIn('id',function($query){
			$query->select('book_id')->from(with(new Borrow)->getTable())->where('status','=','Dipinjam');
		})->where('id','=',Request::input('kode'))->get(['books.judul']);

		return Response::json($book);
	}

	public function postMember()
	{
		$member = Member::where('id','=',Request::input('id'))->get(['members.nama']);

		return Response::json($member);
	}

	public function postReturn()
	{
		$borrow = Borrow::find(Request::input('id'));

		if(count($borrow) > 0)
		{
			$member = Member::findOrFail($borrow->member_id)->get(['members.id','members.nama']);
			$book = Book::findOrFail($borrow->book_id)->get(['books.id','books.judul']);

			return Response::json(['member' => $member, 'book' => $book]);
		}
	}

}
