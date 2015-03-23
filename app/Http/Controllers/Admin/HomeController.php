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
		$books = Model\Book::all();
		$asli = Model\Book::where('jenis','=','asli')->get();
		$pkl = Model\Book::where('jenis','=','pkl')->get();
		return view('admin.home', compact('books','asli','pkl'));
	}

	public function lockscreen()
	{
		return view('auth.lockscreen');
	}

}
