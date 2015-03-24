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
		return view('admin.home', compact('books','asli','pkl'));
	}

	public function lockscreen()
	{
		return view('auth.lockscreen');
	}

}
