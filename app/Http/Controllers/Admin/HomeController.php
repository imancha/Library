<?php namespace App\Http\Controllers\Admin;

use App\Model;
use App\Http\Controllers\Controller;

class HomeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$books = Model\Book::count();
		$asli = Model\Book::where('jenis','=','asli')->count();
		$pkl = Model\Book::where('jenis','=','pkl')->count();
		$members = Model\Member::count();
		$karyawan = Model\Member::where('jenis_anggota','=','Karyawan')->count();
		$nonkaryawan = Model\Member::where('jenis_anggota','=','Non-Karyawan')->count();
		return view('admin.home', compact('books','asli','pkl','members','karyawan','nonkaryawan'));
	}

	public function lockscreen()
	{
		return view('auth.lockscreen');
	}

}
