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
		$karyawan = Member::where('jenis_anggota','=','karyawan')->count();
		$nonkaryawan = Member::where('jenis_anggota','=','non-karyawan')->count();
		$borrows = Borrow::count();
		$pinjam = Borrow::where('status','like','%pinjam%')->count();
		$kembali = Borrow::where('status','like','%kembali%')->count();

		return view('admin.index', compact('books','asli','pkl','members','karyawan','nonkaryawan','borrows','pinjam','kembali'));
	}

	public function lockscreen()
	{
		return view('auth.lockscreen');
	}

	public function postBook()
	{
		$book = Book::whereNotIn('id',function($query){
			$query->select('book_id')->from(with(new Borrow)->getTable())->where('status','like','%pinjam%');
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
		$borrows = Book::join('borrows', function($join){
			$join->on('borrows.book_id','=','books.id')->where('borrows.status','like','%pinjam%')->where('borrows.member_id','=',Request::input('id'));
		})->get(['borrows.id','borrows.book_id','books.judul','borrows.tanggal_pinjam']);

		return Response::json($borrows);
	}

}
