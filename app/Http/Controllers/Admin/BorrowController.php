<?php namespace App\Http\Controllers\Admin;

use Excel;
use Redirect;
use App\Model\Book;
use App\Model\Borrow;
use App\Model\Member;
use App\Http\Requests\CreateBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;
use App\Http\Controllers\Controller;

class BorrowController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$borrows = Borrow::orderBy('created_at','desc')->paginate(15);
		$borrows->setPath('../admin/borrow');

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
			$query->select('book_id')->from(with(new Borrow)->getTable())->where('status','=','Dipinjam');
		})->get(['books.id']);
		$borrow = Borrow::orderBy('created_at','desc')->first();

		return view('admin.borrow.create',compact('members','books','borrow'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateBorrowRequest $request)
	{
		$member = Member::where('id','=',trim(strip_tags($request->input('id'))))->first();
		$book = Book::where('id','=',trim(strip_tags($request->input('kode'))))->first();

		Borrow::create([
			'id'	=>	trim(strip_tags($request->input('idp'))),
			'tanggal_pinjam'	=>	new \DateTime,
			'member_id'	=>	$member->id,
			'book_id'		=>	$book->id,
		]);

		return Redirect::route('admin.borrow.create')->with('message', (trim(strip_tags($request->input('idp')))).' berhasil disimpan.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($status)
	{
		$borrows = Borrow::where('status','like','%'.$status.'%')->orderBy('created_at','desc')->paginate(15);
		$borrows->setPath('../borrow/'.$status);

		return view('admin.borrow.index', compact('borrows'));
	}

	public function patch()
	{
		$borrows = Borrow::where('status','=','Dipinjam')->get(['borrows.id']);

		return view('admin.borrow.patch',compact('borrows'));
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
	public function update(UpdateBorrowRequest $request)
	{
		$borrow = Borrow::find($request->input('idp'));
		$borrow->tanggal_kembali = new \DateTime;
		$borrow->status = 'Dikembalikan';
		$borrow->save();

		return Redirect::route('admin.borrow.return')->with('message', (trim(strip_tags($request->input('idp')))).' berhasil disimpan.');
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

		$borrows = Borrow::orderBy('created_at','asc')->get();

		if($type == 'xlsx'){
			Excel::create('['.date('Y.m.d H.m.s').'] Data Peminjaman', function($excel) use($borrows){
				$excel->setTitle('Data Peminjaman');
				$excel->setCreator('Perpustakaan PT. INTI')->setCompany('PT. INTI');
				$excel->setDescription('Data Peminjaman Perpustakaan PT. INTI');
				$excel->setlastModifiedBy('Perpustakaan PT. INTI');
				$excel->sheet('Peminjaman', function($sheet) use($borrows){
					$row = 1;
					$sheet->freezeFirstRow();
					$sheet->setFontFamily('Sans Serif');
					$sheet->row($row, ['ID','NIP/NIM/NIS','NAMA','KODE BUKU','JUDUL BUKU','TANGGAL PINJAM','TANGGAL KEMBALI','STATUS']);
					foreach($borrows as $borrow)
					{
						$sheet->row(++$row, [
							$borrow->id,
							$borrow->member_id,
							$borrow->member->nama,
							$borrow->book_id,
							$borrow->book->judul,
							implode('-',array_reverse(explode('-',$borrow->tanggal_pinjam))),
							implode('-',array_reverse(explode('-',$borrow->tanggal_kembali))),
							$borrow->status,
						]);
					}
				});
			})->export($type);
		}
	}

}
