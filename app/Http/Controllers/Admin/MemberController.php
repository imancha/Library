<?php namespace App\Http\Controllers\Admin;

use App\Model;
use App\Http\Requests;
use App\Http\Requests\CreateMemberRequest;
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
	public function store(CreateMemberRequest $request)
	{
		Model\Member::firstOrCreate([
			'id'		=>	trim(strip_tags($request->input('id'))),
			'nama'	=>	trim(strip_tags($request->input('nama'))),
			'tanggal_lahir'	=>	trim(strip_tags($request->input('tahun').'-'.$request->input('bulan').'-'.$request->input('tanggal'))),
			'jenis_kelamin'	=>	trim(strip_tags($request->input('jk'))),
			'jenis_anggota'	=>	trim(strip_tags($request->input('ja'))),
			'phone'		=>	trim(strip_tags($request->input('phone'))),
			'alamat'	=>	trim(strip_tags($request->input('alamat'))),
			'keterangan'		=>	trim(strip_tags($request->input('keterangan'))),
		]);

		return \Redirect::route('admin.member.create')->with('message', (trim(strip_tags($request->input('id')))).' - '.(trim(strip_tags($request->input('nama')))).' berhasil disimpan.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($jenis)
	{
		$members = Model\Member::where('jenis_anggota','=',$jenis)->orderBy('created_at','desc')->paginate(15);
		return view('admin.member.index', compact('members'));
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
