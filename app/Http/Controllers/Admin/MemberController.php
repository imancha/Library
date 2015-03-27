<?php namespace App\Http\Controllers\Admin;

use Input;
use Redirect;
use App\Model;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MemberController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$members = Model\Member::orderBy('created_at','desc')->paginate(15);
		return view('admin.member.index', compact('members'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.member.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		Model\Member::firstOrCreate([
			'id'		=>	Input::get('id'),
			'nama'	=>	Input::get('nama'),
			'tanggal_lahir'	=>	(implode('-',array_reverse(Input::get('lahir')))),
			'jenis_kelamin'	=>	Input::get('jk'),
			'jenis_anggota'	=>	Input::get('ja'),
			'phone'		=>	Input::get('phone'),
			'alamat'	=>	Input::get('alamat'),
			'keterangan'		=>	Input::get('keterangan'),
		]);


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
