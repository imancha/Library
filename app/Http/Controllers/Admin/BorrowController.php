<?php namespace App\Http\Controllers\Admin;

use Excel;
use Validator;
use App\Model\Book;
use App\Model\Borrow;
use App\Model\Member;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BorrowController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if($request->has('q')){
			$q = trim(strip_tags($request->input('q')));
			$borrows = Borrow::where('id','like','%'.$q.'%')->orWhere('member_id','like','%'.$q.'%')->orWhere('book_id','like','%'.$q.'%')->orWhere('waktu_pinjam','like','%'.$q.'%')->orWhere('waktu_kembali','like','%'.$q.'%')->orWhere('status','like','%'.$q.'%')->orWhereIn('member_id',Member::whereIn('id',Borrow::groupBy('member_id')->get(['borrows.member_id'])->toArray())->where('nama','like','%'.$q.'%')->get(['members.id'])->toArray())->orWhereIn('book_id',Book::whereIn('id',Borrow::groupBy('book_id')->get(['borrows.book_id'])->toArray())->where('judul','like','%'.$q.'%')->get(['books.id'])->toArray())->orderBy('waktu_pinjam','desc')->paginate(10);
			$borrows->setPath('../admin/borrow^q='.$q);
		}else{
			$borrows = Borrow::orderBy('waktu_pinjam','desc')->paginate(10);
			$borrows->setPath('../admin/borrow');
		}

		return view('admin.borrow.index', compact('borrows'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$members = Member::all(['members.id']);

		$books = Book::whereNotIn('id', function($query){
			$query->select('book_id')->from(with(new Borrow)->getTable())->where('status','like','%pinjam%');
		})->get(['books.id']);

		$borrow = Borrow::orderBy('waktu_pinjam','desc')->first();

		if(count($borrow) > 0){
			$borrow = remove_alpha($borrow->id);
			do{
				empty(Borrow::find('P'.++$borrow)) ? $next = false : $next = true;
			}while($next);
		}else{
			$borrow = 1;
		}

		return view('admin.borrow.create', compact('members','books','borrow'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

		$rules = [
			'idp'		=>	'required|min:2|',
			'id'		=>	'required|min:3|numeric',
			'nama'	=>	'required|min:3',
			'kode'	=>	'required|exists:books,id',
		];

		$validator = Validator::make($request->all(), $rules);

		$validator->after(function($validator) use($request){
			if(is_alay($request->input('nama'))){
				$validator->errors()->add('nama', 'The nama must be alphabetic.');
			}
		});

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator->messages());
		}else{
			empty(Member::find(trim(strip_tags($request->input('id'))))) ? $empty = true : $empty = false;

			$member = Member::firstOrCreate([
				'id' => trim(strip_tags($request->input('id'))),
				'nama' => trim(strip_tags($request->input('nama'))),
			]);

			foreach($request->input('kode') as $kode){
				$book = Book::find(trim(strip_tags($kode)));

				Borrow::create([
					'id'	=>	trim(strip_tags($request->input('idp'))),
					'waktu_pinjam'	=>	new \DateTime,
					'member_id'	=>	trim(strip_tags($request->input('id'))),
					'book_id'		=>	$book->id,
				]);
			}

			if($empty)
				return redirect()->action('Admin\MemberController@edit', [trim(strip_tags($request->input('id')))])->withMessage(trim(strip_tags($request->input('idp'))).' berhasil disimpan.');

			return redirect()->action('Admin\BorrowController@create')->withMessage(trim(strip_tags($request->input('idp'))).' berhasil disimpan.');
		}
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

	public function patch()
	{
		$members = Borrow::where('status','like','%pinjam%')->distinct()->get(['borrows.member_id']);
		$books = Borrow::where('status','like','%pinjam%')->distinct()->get(['borrows.book_id']);

		return view('admin.borrow.patch',compact('members','books'));
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
	public function update(Request $request)
	{
		if(!empty($request->input('kode'))){
			$book = [];
			foreach($request->input('kode') as $kode){
				$kode = explode('/',$kode);
				$borrow = Borrow::where('id','=',$kode[0])->where('book_id','=',$kode[1])->where('status','like','%pinjam%')->update(['waktu_kembali' => new \DateTime,'status' => 'pengembalian/tersedia']);
				$book[] = $kode[1];
				$kode = [];
			}

			return redirect()->back()->withMessage(implode(', ',$book).' berhasil disimpan.');
		}
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

		$borrows = Borrow::orderBy('waktu_pinjam','asc')->get();

		if($type == 'xls'){
			Excel::create('['.date('Y.m.d H.m.s').'] Data Peminjaman Buku Perpustakaan INTI', function($excel) use($borrows){
				$excel->setTitle('Data Peminjaman');
				$excel->setCreator('Perpustakaan INTI')->setCompany('PT. INTI');
				$excel->setDescription('Data Peminjaman Buku Perpustakaan INTI');
				$excel->setlastModifiedBy('Perpustakaan INTI');
				$excel->sheet('PEMINJAMAN', function($sheet) use($borrows){
					$row = 1;
					$sheet->freezeFirstRow();
					$sheet->setFontFamily('Sans Serif');
					$sheet->row($row, ['ID','NIP/NIM/NIS','NAMA','KODE BUKU','JUDUL BUKU','WAKTU PINJAM','WAKTU KEMBALI','STATUS']);
					foreach($borrows as $borrow)
					{
						$sheet->row(++$row, [
							$borrow->id,
							$borrow->member_id,
							$borrow->member->nama,
							$borrow->book_id,
							$borrow->book->judul,
							$borrow->waktu_pinjam,
							$borrow->waktu_kembali,
							empty($borrow->status) ? '' : $borrow->status == 'peminjaman/dipinjam' ? 'Peminjaman' : 'Pengembalian',
						]);
					}
				});
			})->export($type);
		}
	}

}
