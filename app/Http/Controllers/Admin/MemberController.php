<?php namespace App\Http\Controllers\Admin;

use Excel;
use Redirect;
use App\Model\Member;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Controllers\Controller;

class MemberController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$members = Member::orderBy('created_at','desc')->paginate(15);
		$members->setPath('../admin/member');

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
		Member::firstOrCreate([
			'id'		=>	trim(strip_tags($request->input('id'))),
			'nama'	=>	trim(strip_tags($request->input('nama'))),
			'tanggal_lahir'	=>	trim(strip_tags($request->input('tahun').'-'.$request->input('bulan').'-'.$request->input('tanggal'))),
			'jenis_kelamin'	=>	trim(strip_tags($request->input('jk'))),
			'jenis_anggota'	=>	trim(strip_tags($request->input('ja'))),
			'phone'		=>	trim(strip_tags($request->input('phone'))),
			'alamat'	=>	trim(strip_tags($request->input('alamat'))),
			'keterangan'		=>	trim(strip_tags($request->input('keterangan'))),
		]);

		return Redirect::route('admin.member.create')->with('message', (trim(strip_tags($request->input('id')))).' - '.(trim(strip_tags($request->input('nama')))).' berhasil disimpan.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($jenis)
	{
		$members = Member::where('jenis_anggota','=',$jenis)->orderBy('created_at','desc')->paginate(15);
		$members->setPath('../member/'.$jenis);

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

	public function export($type)
	{
		set_time_limit (500);
		ini_set('memory_limit', '500M');
		\PHPExcel_Settings::setCacheStorageMethod(\PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp, ['memoryCacheSize' => '256M']);

		$members = Member::orderBy('created_at','asc')->get();

		if($type == 'xlsx'){
			Excel::create('['.date('Y.m.d H.m.s').'] Data Anggota', function($excel) use($members){
				$excel->setTitle('Data Anggota');
				$excel->setCreator('Perpustakaan PT. INTI')->setCompany('PT. INTI');
				$excel->setDescription('Data Anggota Perpustakaan PT. INTI');
				$excel->setlastModifiedBy('Perpustakaan PT. INTI');
				$excel->sheet('Anggota', function($sheet) use($members){
					$row = 1;
					$sheet->freezeFirstRow();
					$sheet->setFontFamily('Sans Serif');
					$sheet->row($row, ['NIP/NIM/NIS','NAMA','TANGGAL LAHIR','JENIS KELAMIN','JENIS ANGGOTA','NOMOR TELEPON','ALAMAT','KETERANGAN']);
					foreach($members as $member)
					{
						$sheet->row(++$row, [
							$member->id,
							$member->nama,
							implode('-',array_reverse(explode('-',$member->tanggal_lahir))),
							$member->jenis_kelamin,
							$member->jenis_anggota,
							$member->phone,
							$member->alamat,
							$member->keterangan,
						]);
					}
				});
			})->export($type);
		}
	}

}
