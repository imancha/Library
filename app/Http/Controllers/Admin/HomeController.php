<?php namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Request;
use Validator;
use App\Model\Book;
use App\Model\Borrow;
use App\Model\GuestBook;
use App\Model\Member;
use App\Model\Slider;
use App\Http\Controllers\Controller;

class HomeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$guests = GuestBook::orderBy('waktu','desc')->get();
		$sliders = Slider::all();
		$beranda = welcome();
		$slider = slider();
		$slider_ = slider_(0);
		$slider__ = slider_(1);
		$gallery = array_filter(explode(' && ', gallery()));

		return view(Auth::user()->status.'.index', compact('guests','sliders','beranda','slider','gallery','slider_','slider__'));
	}

	public function getData($data = '')
	{
		if(Request::has('start') && Request::has('end')){
			if(Request::input('id') == 1){
				foreach(DB::table('members')->select(DB::raw('date(waktu) as waktu, count(id) as id'))->whereBetween(DB::raw('date(waktu)'),[trim(strip_tags(Request::input('start'))),trim(strip_tags(Request::input('end')))])->groupBy(DB::raw('date(waktu)'))->orderBy('waktu','desc')->get() as $key => $member){
					$data[$key]['label'] = str_replace('-','/',$member->waktu);
					$data[$key]['value'] = $member->id;
				}
			}elseif(Request::input('id') == 2){
				foreach(DB::table('borrows')->select(DB::raw('date(waktu_pinjam) as waktu_pinjam'))->whereBetween(DB::raw('date(waktu_pinjam)'),[trim(strip_tags(Request::input('start'))),trim(strip_tags(Request::input('end')))])->groupBy(DB::raw('date(waktu_pinjam)'))->orderBy('waktu_pinjam','desc')->get() as $key => $borrow){
					$data[$key]['label'] = str_replace('-','/',$borrow->waktu_pinjam);
					$data[$key]['value'] = count(array_map('unserialize',array_unique(array_map('serialize',Borrow::where('waktu_pinjam','like',$borrow->waktu_pinjam.'%')->get(['borrows.id'])->toArray()))));
				}
			}else{
				foreach(DB::table('books')->select(DB::raw('date(tanggal_masuk) as tanggal_masuk, count(id) as id'))->whereBetween(DB::raw('date(tanggal_masuk)'),[trim(strip_tags(Request::input('start'))),trim(strip_tags(Request::input('end')))])->groupBy(DB::raw('date(tanggal_masuk)'))->orderBy('tanggal_masuk','desc')->get() as $key => $book){
					$data[$key]['label'] = str_replace('-','/',$book->tanggal_masuk);
					$data[$key]['value'] = $book->id;
				}
			}
		}

		return response()->json($data);
	}

	public function getDetail($data = '')
	{
		if(Request::has('id')){
			if(Request::input('it') == 1){
				foreach(Member::where('waktu','like',trim(strip_tags(str_replace('/','-',Request::input('id'))).'%'))->orderBy('waktu','asc')->get() as $key => $member){
					$data[$key]['kode'] = $member->id;
					$data[$key]['nama'] = $member->nama;
					$data[$key]['jkel'] = $member->jenis_kelamin == 'perempuan' ? 'Perempuan' : 'Laki-Laki';
					$data[$key]['jang'] = $member->jenis_anggota == 'karyawan' ? 'Karyawan' : 'Non-Karyawan';
					$data[$key]['alam'] = $member->alamat;
				}
			}elseif(Request::input('it') == 2){
				foreach(Borrow::whereIn('id',array_map('unserialize',array_unique(array_map('serialize',Borrow::where('waktu_pinjam','like',trim(strip_tags(str_replace('/','-',Request::input('id'))).'%'))->orderBy('waktu_pinjam','asc')->get(['borrows.id'])->toArray()))))->groupBy('id')->orderBy('waktu_pinjam','asc')->get() as $key => $borrow){
					$data[$key]['kode'] = $borrow->id;
					$data[$key]['pinj'] = $borrow->waktu_pinjam;
					$data[$key]['nipn'] = $borrow->member->id;
					$data[$key]['nama'] = $borrow->member->nama;
					$result = '';
					foreach(Borrow::where('id','=',$borrow->id)->get() as $val)
						$result .= '<tr><td width="78px">'.$val->book->id.'</td><td width="385px">'.$val->book->judul.'</td><td width="100px">'.(empty($val->waktu_kembali) ? ' ' : $val->waktu_kembali).'</td><td width="124px">'.(empty($val->waktu_kembali) ? 'Peminjaman' : 'Pengembalian').'</td></tr>';
					$data[$key]['buku'] = $result;
				}
			}else{
				foreach(Book::where('tanggal_masuk','like',trim(strip_tags(str_replace('/','-',Request::input('id'))).'%'))->orderBy('tanggal_masuk','asc')->get() as $key => $book){
					$data[$key]['kode'] = $book->id;
					$data[$key]['judul'] = $book->judul;
					$authors = [];
					foreach($book->author as $author)
						$authors[] = $author->nama;
					$data[$key]['pengarang'] = implode(', ',$authors);
					$data[$key]['penerbit'] = $book->publisher->nama;
					$data[$key]['tahun'] = $book->tahun;
					$data[$key]['subyek'] = $book->subject->nama;
					$data[$key]['rak'] = $book->rack->nama;
					$data[$key]['jenis'] = strtoupper($book->jenis);
				}
			}
		}
		return response()->json($data);
	}

	public function postAddress()
	{
		$result = \File::put(public_path('/inc/').(Request::input('id') == 1 ? 'location' : 'address'), trim(strip_tags(Request::input('txt'))));
		if($result === false) die("Error writing to file");

		return response()->json($result);
	}

	public function postBook()
	{
		$book = Book::whereNotIn('id',function($query){
			$query->select('book_id')->from(with(new Borrow)->getTable())->where('status','like','%pinjam%');
		})->where('id','=',Request::input('kode'))->get(['books.judul']);

		return response()->json($book);
	}

	public function postMember()
	{
		if(Request::input('id') == 1)
			$result = Member::where('id','=',Request::input('id1'))->get(['members.nama']);
		else
			$result = Book::where('id','=',Request::input('id2'))->get(['books.judul']);

		return response()->json($result);
	}

	public function postReturn()
	{
		if(Request::input('id') == 1){
			$result = Book::join('borrows', function($join){
				$join->on('borrows.book_id','=','books.id')->where('borrows.status','like','%pinjam%')->where('borrows.member_id','=',Request::input('id1'));
			})->get(['borrows.id','borrows.book_id','books.judul','borrows.waktu_pinjam']);
		}else{
			$result = Member::join('borrows', function($join){
				$join->on('borrows.member_id','=','members.id')->where('borrows.status','like','%pinjam%')->where('borrows.book_id','=',Request::input('id2'));
			})->get(['borrows.id','borrows.book_id','borrows.member_id','members.nama','borrows.waktu_pinjam']);
		}

		return response()->json($result);
	}

	public function postSlider()
	{
		$result = \File::put(public_path('/inc/slider'), trim(strip_tags(Request::input('keterangan'))));

		if($result === false) die("Error writing to file");

		return redirect()->back()->withMessage('Slider-Start berhasil disimpan.');
	}

	public function postSlider_()
	{
		$result = \File::put(public_path('/inc/slider_'), Request::input('keterangan'));

		if($result === false) die("Error writing to file");

		if(Request::hasFile('img')){
			$path = public_path('/img/slider/');
			$file = Request::file('img');

			$validator = Validator::make(
				['image' => $file], ['image' => 'mimes:jpg,jpeg,png,gif']
			);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator->messages());
			}else{
				$name = 'slide-end.'.$file->getClientOriginalExtension();
				$fiel = $path.$name;

				if(\File::exists($path.Request::input('_img'))) \File::delete($path.Request::input('_img'));
				if(\File::exists($fiel)) \File::delete($fiel);

				if($file->move($path,$name)){
					$result = \File::append(public_path('/inc/slider_'), ' && '.$name);
					if($result === false) die("Error writing to file");
				}else{
					return redirect()->back()->withErrors('Error uploading file.');
				}
			}
		}

		return redirect()->back()->withMessage('Slider-End berhasil disimpan.');
	}

	public function postDashboard()
	{
		if(Request::hasFile('img')){
			$path = public_path('/img/');
			$file = Request::file('img');

			$validator = Validator::make(
				['image' => $file], ['image' => 'mimes:jpg,jpeg,png,gif']
			);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator->messages());
			}else{
				$name = 'beranda.'.$file->getClientOriginalExtension();
				$fiel = $path.$name;

				if(\File::exists($path.Request::input('_file'))) \File::delete($path.Request::input('_file'));
				if(\File::exists($fiel)) \File::delete($fiel);

				if($file->move($path,$name))
					$img = '<img id="img" src="./img/'.$name.'" class="img img-responsive" alt="'.$name.'" width="200px" height="200px" style="float:right;display:inline;margin:10px 0 10px 10px;">';
			}
		}else{
			$img = '<img id="img" src="./img/'.Request::input('_file').'" class="img img-responsive" alt="'.Request::input('_file').'" width="200px" height="200px" style="float:right;display:inline;margin:15px 0 10px 10px;">';
		}

		$result = \File::put(public_path('/inc/dashboard'),'<h3 id="title" style="margin-top:5px;">'.Request::input('title').'</h3>'.$img.'<div id="post" style="margin-top:20px">'.Request::input('post').'</div>');

		if($result === false) die("Error writing to file");

		return redirect()->back()->withMessage('Beranda berhasil disimpan.');
	}

	public function guestBook()
	{
		GuestBook::where('id','=',Request::input('id'))->delete();

		return redirect()->back()->withMessage('Komentar dari '.Request::input('nama').' berhasil dihapus');
	}

	public function postGallery()
	{
		if(Request::hasFile('file')){
			$path = public_path('/img/slider-deal/');
			$file = Request::file('file');

			$validator = Validator::make(
				['image' => $file], ['image' => 'mimes:jpg,jpeg,png,gif']
			);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator->messages());
			}else{
				$name = trim($file->getClientOriginalName());
				if($file->move($path,$name)){
					$result = \File::append(public_path('/inc/gallery'), ' && '.$name);
					if($result === false) die("Error writing to file");

					return redirect()->back()->withMessage('Gallery berhasil disimpan.');
				}
			}
		}
		return redirect()->back()->withErrors('Error uploading file.');
	}

	public function getGallery($id)
	{
		foreach(array_filter(explode(' && ', gallery())) as $galery){
			if(sha1($galery) == $id)
				$delete = $galery;
			else
				$gallery[] = $galery;
		}

		if(\File::exists(public_path('/img/slider-deal/'.$delete)))
			\File::delete(public_path('/img/slider-deal/'.$delete));
		if(\File::put(public_path('/inc/gallery'), implode(' && ', $gallery)) === false) die("Error writing to file");

		return redirect()->back()->withMessage('Gambar berhasil dihapus.');
	}
}
