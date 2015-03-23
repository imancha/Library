<?php namespace App\Http\Controllers;

use App\Model;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BookController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$books = Model\Book::orderBy('tanggal_masuk','desc')->paginate(15);
		return view('admin.buku.index', compact('books'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$publishers = Model\Publisher::orderBy('created_at', 'desc')->get();
		$subjects = Model\Subject::orderBy('created_at', 'desc')->get();
		$racks = Model\Rack::orderBy('created_at', 'desc')->get();
		return view('admin.buku.create', compact('publishers','subjects','racks'));
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
	public function show($jenis)
	{
		$books = Model\Book::where('jenis','=',strtoupper($jenis))->orderBy('tanggal_masuk','desc')->paginate(15);
		return view('admin.buku.index', compact('books'));
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
