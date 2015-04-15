<?php namespace App\Http\Controllers\Admin;

use Excel;
use Redirect;
use App\Model\Borrow;
use App\Model\Member;
use App\Http\Requests;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\EditMemberRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MemberController extends Controller {

	private $perpage = 10;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$borrows = Borrow::groupBy('id')->get();
		if($request->has('q'))
		{
			$q = $request->input('q');
			$members = Member::where('id','like','%'.$q.'%')->orWhere('nama','like','%'.$q.'%')->orWhere('jenis_kelamin','like','%'.$q.'%')->orWhere('jenis_anggota','like','%'.$q.'%')->orWhere('alamat','like','%'.$q.'%')->orderBy('created_at','asc')->paginate($this->perpage);
			$members->setPath('../admin/member^q='.$q);
		}else{
			$members = Member::orderBy('created_at','asc')->paginate($this->perpage);
			$members->setPath('../admin/member');
		}

		return view('admin.member.index', compact('borrows','members'));
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
			'tanggal_lahir'	=>	trim(strip_tags($request->input('lahir'))),
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
		$member = Member::find($id);

		return view('admin.member.edit', compact('member'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EditMemberRequest $request, $id)
	{
		$member = Member::find($id);
		$member->id = trim(strip_tags($request->input('id')));
		$member->nama = trim(strip_tags($request->input('nama')));
		$member->tanggal_lahir = trim(strip_tags($request->input('lahir')));
		$member->jenis_kelamin = trim(strip_tags($request->input('jk')));
		$member->jenis_anggota = trim(strip_tags($request->input('ja')));
		$member->phone = trim(strip_tags($request->input('phone')));
		$member->alamat = trim(strip_tags($request->input('alamat')));
		$member->keterangan = trim(strip_tags($request->input('keterangan')));
		$member->save();

		return Redirect::route('admin.member.index')->with('message', (trim(strip_tags($request->input('id')))).' - '.(trim(strip_tags($request->input('nama')))).' berhasil disimpan.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		Member::where('id','=',$id)->delete();
		Borrow::where('member_id','=',$id)->delete();

		return redirect()->back()->with('message', $request->input('id').' - '.$request->input('nama').' berhasil dihapus.');
	}

	public function export($type)
	{
		set_time_limit (500);
		ini_set('memory_limit', '500M');
		\PHPExcel_Settings::setCacheStorageMethod(\PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp, ['memoryCacheSize' => '256M']);

		$members = Member::orderBy('created_at','asc')->get();

		if($type == 'xlsx'){
			Excel::create('['.date('Y.m.d H.m.s').'] Data Anggota Perpustakaan PT. INTI', function($excel) use($members){
				$excel->setTitle('Data Anggota');
				$excel->setCreator('Perpustakaan PT. INTI')->setCompany('PT. INTI');
				$excel->setDescription('Data Anggota Perpustakaan PT. INTI');
				$excel->setlastModifiedBy('Perpustakaan PT. INTI');
				$excel->sheet('ANGGOTA', function($sheet) use($members){
					$row = 1;
					$sheet->freezeFirstRow();
					$sheet->setFontFamily('Sans Serif');
					$sheet->row($row, ['NIP/NIM/NIS','NAMA','TANGGAL LAHIR','JENIS KELAMIN','JENIS ANGGOTA','NOMOR TELEPON','ALAMAT/DIVISI','KETERANGAN']);
					foreach($members as $member)
					{
						$sheet->row(++$row, [
							$member->id,
							$member->nama,
							implode('-',array_reverse(explode('-',$member->tanggal_lahir))),
							strtoupper($member->jenis_kelamin),
							strtoupper($member->jenis_anggota),
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
