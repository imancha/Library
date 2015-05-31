<?php namespace App\Http\Controllers\Admin;

use Auth;
use Excel;
use Validator;
use App\Model\Borrow;
use App\Model\Member;
use App\Http\Requests;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\EditMemberRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$borrows = Borrow::groupBy('id')->get();
		if($request->has('q')){
			$q = trim(strip_tags($request->input('q')));
			$members = Member::where('id','like','%'.$q.'%')->orWhere('nama','like','%'.$q.'%')->orWhere('jenis_kelamin','like','%'.$q.'%')->orWhere('jenis_anggota','like','%'.$q.'%')->orWhere('alamat','like','%'.$q.'%')->orWhere('keterangan','like','%'.$q.'%')->orderBy('nama','asc')->paginate(10);
			$members->setPath('../admin/member^q='.$q);
		}else{
			$members = Member::orderBy('nama','asc')->paginate(10);
			$members->setPath('../admin/member');
		}

		return view(Auth::user()->status.'.member.index', compact('borrows','members'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view(Auth::user()->status.'.member.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$rules = [
			'id'					=>	'required|min:3|max:15|unique:members,id',
			'nama'				=>	'required|min:3|max:50',
			'lahir'				=>	'min:3',
			'jk'					=>	'required',
			'ja'					=>	'required',
			'phone'				=>	'min:8|max:12',
			'alamat'			=>	'min:3|max:255',
			'keterangan'	=>	'min:3|max:255',
		];

		$messages = [
			'id.required'			=>	'NIP/NIM/NIS harus diisi.',
			'id.min'					=>	'NIP/NIM/NIS minimal 3 karakter.',
			'id.max'					=>	'NIP/NIM/NIS maksimal 15 karakter.',
			'id.unique'				=>	'NIP/NIM/NIS telah digunakan.',
			'nama.required'		=>	'Nama haris diisi.',
			'nama.min'				=> 	'Nama minimal 3 karakter.',
			'nama.max'				=>	'Nama maksimal 50 karakter.',
			'lahir.min'				=>	'Tempat & Tanggal Lahir minimal 3 karakter.',
			'jk.required'			=>	'Jenis Kelamin harus dipilih.',
			'ja.required'			=>	'Jenis Anggota harus dipilih.',
			'phone.min'				=>	'Nomor Telepon minimal 8 karakter.',
			'phone.max'				=>	'Nomor Telepon maksimal 12 karakter.',
			'alamat.min'			=>	'Alamat/Divisi minimal 3 karakter.',
			'alamat.max'			=>	'Alamat/Divisi maksimal 255 karakter.',
			'keterangan.min'	=>	'Keterangan minimal 3 karakter.',
			'keterangan.max'	=>	'Keterangan maksimal 255 karakter.',
		];

		$validator = Validator::make($request->all(), $rules, $messages);

		$validator->after(function($validator) use($request){
			if(!is_numeric($request->input('id')))
				$validator->errors()->add('id', 'NIP/NIM/NIS hanya boleh berupa angka.');
			if(is_alay($request->input('nama')))
				$validator->errors()->add('nama', 'Nama hanya boleh berupa huruf.');
			if(!is_numeric($request->input('phone')))
				$validator->errors()->add('phone', 'Nomor Telepon hanya boleh berupa angka.');
		});

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator);
		}else{
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

			return redirect()->action('Admin\MemberController@create')->withMessage(trim(strip_tags($request->input('id'))).' - '.trim(strip_tags($request->input('nama'))).' berhasil disimpan.');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request,$id)
	{
		$member = Member::find($id);

		if($request->has('from') && $request->has('to'))
			$borrows = Borrow::where('member_id','=',$member->id)->whereBetween('waktu_pinjam',[trim(strip_tags(implode('-',array_reverse(explode('-',$request->input('from')))))). '00:00:00',trim(strip_tags(implode('-',array_reverse(explode('-',$request->input('to')))))).' 23:59:59'])->orderBy('waktu_pinjam','asc')->get();
		else
			$borrows = Borrow::where('member_id','=',$member->id)->orderBy('waktu_pinjam','asc')->get();

		return view('staff.member.show', compact('member','borrows'));
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

		return view(Auth::user()->status.'.member.edit', compact('member'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$rules = [
			'id'					=>	'required|min:3|max:15|exists:members,id',
			'nama'				=>	'required|min:3|max:50',
			'lahir'				=>	'min:3',
			'jk'					=>	'required',
			'ja'					=>	'required',
			'phone'				=>	'min:8|max:12',
			'alamat'			=>	'min:3|max:255',
			'keterangan'	=>	'min:3|max:255',
		];

		$messages = [
			'id.required'			=>	'NIP/NIM/NIS harus diisi.',
			'id.min'					=>	'NIP/NIM/NIS minimal 3 karakter.',
			'id.max'					=>	'NIP/NIM/NIS maksimal 15 karakter.',
			'id.exists'				=>	'NIP/NIM/NIS tidak ditemukan.',
			'nama.required'		=>	'Nama haris diisi.',
			'nama.min'				=> 	'Nama minimal 3 karakter.',
			'nama.max'				=>	'Nama maksimal 50 karakter.',
			'lahir.min'				=>	'Tempat & Tanggal Lahir minimal 3 karakter.',
			'jk.required'			=>	'Jenis Kelamin harus dipilih.',
			'ja.required'			=>	'Jenis Anggota harus dipilih.',
			'phone.min'				=>	'Nomor Telepon minimal 8 karakter.',
			'phone.max'				=>	'Nomor Telepon maksimal 12 karakter.',
			'alamat.min'			=>	'Alamat/Divisi minimal 3 karakter.',
			'alamat.max'			=>	'Alamat/Divisi maksimal 255 karakter.',
			'keterangan.min'	=>	'Keterangan minimal 3 karakter.',
			'keterangan.max'	=>	'Keterangan maksimal 255 karakter.',
		];

		$validator = Validator::make($request->all(), $rules, $messages);

		$validator->after(function($validator) use($request){
			if(!is_numeric($request->input('id')))
				$validator->errors()->add('id', 'NIP/NIM/NIS hanya boleh berupa angka.');
			if(is_alay($request->input('nama')))
				$validator->errors()->add('nama', 'Nama hanya boleh berupa huruf.');
			if(!is_numeric($request->input('phone')))
				$validator->errors()->add('phone', 'Nomor Telepon hanya boleh berupa angka.');
		});

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator->messages());
		}else{
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

			return redirect()->action('Admin\MemberController@index')->withMessage(trim(strip_tags($request->input('id'))).' - '.trim(strip_tags($request->input('nama'))).' berhasil disimpan.');
		}
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

		return redirect()->back()->withMessage($request->input('id').' - '.$request->input('nama').' berhasil dihapus.');
	}

	public function export($type)
	{
		set_time_limit (500);
		ini_set('memory_limit', '500M');
		\PHPExcel_Settings::setCacheStorageMethod(\PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp, ['memoryCacheSize' => '256M']);

		$members = Member::orderBy('nama','asc')->get();

		if($type == 'xls'){
			Excel::create('['.date('Y.m.d H.m.s').'] Data Anggota Perpustakaan INTI', function($excel) use($members){
				$excel->setTitle('Data Anggota');
				$excel->setCreator('Perpustakaan INTI')->setCompany('PT. INTI');
				$excel->setDescription('Data Anggota Perpustakaan INTI');
				$excel->setlastModifiedBy('Perpustakaan INTI');
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
							$member->tanggal_lahir,
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
