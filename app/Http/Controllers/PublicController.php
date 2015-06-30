<?php namespace App\Http\Controllers;

use DB;
use App\Model\Author;
use App\Model\Book;
use App\Model\BookAuthor;
use App\Model\Borrow;
use App\Model\File;
use App\Model\GuestBook;
use App\Model\Member;
use App\Model\Publisher;
use App\Model\Rack;
use App\Model\Slider;
use App\Model\Subject;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicController extends Controller {

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$book = Book::count();
		$asli = Book::where('jenis','=','asli')->orderBy('tanggal_masuk','desc')->take(10)->get();
		$pkl = Book::where('jenis','=','pkl')->orderBy('tanggal_masuk','desc')->take(10)->get();
		$sliders = Slider::all();
		$beranda = welcome();
		$slider = slider(0);
		$slidej = slider(1);
		$slider_ = slider_(0);
		$slidej_ = slider_(1);
		$slider__ = slider_(2);
		$gallery = array_filter(explode(' && ', gallery()));

		return view('public.index',compact('book','asli','pkl','sliders','beranda','slider','slidej','gallery','slider_','slidej_','slider__'));
	}

	public function getDownload($file)
	{
		$file = File::where('sha1sum','=',$file)->first();
		if(\File::exists(public_path('files/').$file->book_id.' - '.$file->book->judul.'.'.$file->mime))
			return response()->download((public_path('files/').$file->book_id.' - '.$file->book->judul.'.'.$file->mime), $file->book_id.' - '.$file->book->judul.'.'.$file->mime, ['Content-Type' => 'application/pdf']);
	}

	public function getBook(Request $request, $jenis='')
	{
		$subjects = Subject::orderBy('nama','asc')->get();
		$borrows = Borrow::where('status','like','%pinjam%')->get();
		if(empty($jenis))
		{
			if($request->has('q')){
				$q = trim(strip_tags($request->input('q')));
				$books = Book::where('id','like','%'.$q.'%')->orWhere('judul','like','%'.$q.'%')->orWhere('tahun','like','%'.$q.'%')->orWhere('jenis','like','%'.$q.'%')->orWhere('tanggal_masuk','like','%'.$q.'%')->orWhere('keterangan','like','%'.$q.'%')->orWhereIn('id',BookAuthor::whereIn('author_id',Author::where('nama','like','%'.$q.'%')->get(['authors.id'])->toArray())->get(['book_id'])->toArray())->orWhereIn('publisher_id',Publisher::where('nama','like','%'.$q.'%')->get(['publishers.id'])->toArray())->orWhereIn('subject_id',Subject::where('nama','like','%'.$q.'%')->get(['subjects.id'])->toArray())->orWhereIn('rack_id',Rack::where('nama','like','%'.$q.'%')->get(['racks.id'])->toArray())->orWhereIn('id',Borrow::where('status','like','%'.$q.'%')->get(['borrows.book_id'])->toArray())->orderBy('tanggal_masuk','desc')->paginate(15);
				$books->setPath('./book^q='.$q);
				$title = $q;
			}else{
				$books = Book::orderBy('tanggal_masuk','desc')->paginate(15);
				$books->setPath('./book');
				$title = 'Koleksi Buku';
			}
		}elseif($jenis == 'original' || $jenis == 'research'){
			if($request->has('q')){
				$q = trim(strip_tags($request->input('q')));
				$books = Book::where('jenis','like',($jenis == 'original' ? 'asli' : 'pkl'))->where(function ($query) use($q){
					$query->where('id','like','%'.$q.'%')->orWhere('judul','like','%'.$q.'%')->orWhere('tahun','like','%'.$q.'%')->orWhere('tanggal_masuk','like','%'.$q.'%')->orWhere('keterangan','like','%'.$q.'%')->orWhereIn('id',BookAuthor::whereIn('author_id',Author::where('nama','like','%'.$q.'%')->get(['authors.id'])->toArray())->get(['book_id'])->toArray())->orWhereIn('publisher_id',Publisher::where('nama','like','%'.$q.'%')->get(['publishers.id'])->toArray())->orWhereIn('subject_id',Subject::where('nama','like','%'.$q.'%')->get(['subjects.id'])->toArray())->orWhereIn('rack_id',Rack::where('nama','like','%'.$q.'%')->get(['racks.id'])->toArray())->orWhereIn('id',Borrow::where('status','like','%'.$q.'%')->get(['borrows.book_id'])->toArray());
				})->orderBy('tanggal_masuk','desc')->paginate(15);
				$books->setPath('../book/'.$jenis.'^q='.$q);
				$title = $q;
			}else{
				$books = Book::where('jenis','like',($jenis == 'original' ? 'asli' : 'pkl'))->orderBy('tanggal_masuk','desc')->paginate(15);
				$books->setPath('../book/'.$jenis);
				$title = ($jenis == 'original' ? 'Buku Asli' : 'Buku PKL');
			}
			$subjects = Subject::whereIn('id',Book::where('jenis','=',($jenis == 'original' ? 'asli' : 'pkl'))->get(['books.subject_id'])->toArray())->orderBy('nama','asc')->get();
		}elseif($jenis == 'download'){
			$books = Book::has('file')->orderBy('tanggal_masuk','desc')->paginate(15);
			$title = 'Download Buku';
		}else{
			if($request->has('q')){
				$q = trim(strip_tags($request->input('q')));
				$books = Book::where('subject_id','=',Subject::where('nama','like',str_replace('+',' ',$jenis))->get(['subjects.id'])->toArray())->where(function ($query) use($q){
					$query->where('id','like','%'.$q.'%')->orWhere('judul','like','%'.$q.'%')->orWhere('tahun','like','%'.$q.'%')->orWhere('jenis','like','%'.$q.'%')->orWhere('tanggal_masuk','like','%'.$q.'%')->orWhere('keterangan','like','%'.$q.'%')->orWhereIn('id',BookAuthor::whereIn('author_id',Author::where('nama','like','%'.$q.'%')->get(['authors.id'])->toArray())->get(['book_id'])->toArray())->orWhereIn('publisher_id',Publisher::where('nama','like','%'.$q.'%')->get(['publishers.id'])->toArray())->orWhereIn('rack_id',Rack::where('nama','like','%'.$q.'%')->get(['racks.id'])->toArray())->orWhereIn('id',Borrow::where('status','like','%'.$q.'%')->get(['borrows.book_id'])->toArray());
				})->orderBy('tanggal_masuk','desc')->paginate(15);
				$books->setPath('../book/'.$jenis.'^q='.$q);
				$title = $q;
			}else{
				$books = Book::where('subject_id','=',Subject::where('nama','like',str_replace('+',' ',$jenis))->get(['subjects.id'])->toArray())->orderBy('tanggal_masuk','desc')->paginate(15);
				$books->setPath('../book/'.$jenis);
				$title = ucwords(str_replace('+',' ',$jenis));
			}
		}

		return view('public.book', compact('jenis','subjects','borrows','books','title'));
	}

	public function getMember(Request $request)
	{
		if($request->has('q')){
			$q = trim(strip_tags($request->input('q')));
			$members = Member::where('id','like','%'.$q.'%')->orWhere('nama','like','%'.$q.'%')->orWhere('jenis_kelamin','like','%'.$q.'%')->orWhere('jenis_anggota','like','%'.$q.'%')->orWhere('alamat','like','%'.$q.'%')->orWhere('keterangan','like','%'.$q.'%')->orderBy('nama','asc')->paginate(15);
			$members->setPath('./member^q='.$q);
		}else{
			$members = Member::orderBy('nama','asc')->paginate(15);
			$members->setPath('./member');
		}

		return view('public.member', compact('members'));
	}

	public function getBorrow(Request $request)
	{
		$perpage = 10;
		if($request->has('page')) $page = trim(strip_tags($request->input('page')));
		else $page = 1;

		if($request->has('q')){
			$q = trim(strip_tags($request->input('q')));
			$query = Borrow::where('id','like','%'.$q.'%')->orWhere('member_id','like','%'.$q.'%')->orWhere('book_id','like','%'.$q.'%')->orWhere('waktu_pinjam','like','%'.$q.'%')->orWhere('waktu_kembali','like','%'.$q.'%')->orWhere('status','like','%'.$q.'%')->orWhereIn('member_id',Member::whereIn('id',Borrow::groupBy('member_id')->get(['borrows.member_id'])->toArray())->where('nama','like','%'.$q.'%')->get(['members.id'])->toArray())->orWhereIn('book_id',Book::whereIn('id',Borrow::groupBy('book_id')->get(['borrows.book_id'])->toArray())->where('judul','like','%'.$q.'%')->get(['books.id'])->toArray());
			$total = count(array_map('unserialize',array_unique(array_map('serialize',Borrow::where('id','like','%'.$q.'%')->orWhere('member_id','like','%'.$q.'%')->orWhere('book_id','like','%'.$q.'%')->orWhere('waktu_pinjam','like','%'.$q.'%')->orWhere('waktu_kembali','like','%'.$q.'%')->orWhere('status','like','%'.$q.'%')->orWhereIn('member_id',Member::whereIn('id',Borrow::groupBy('member_id')->get(['borrows.member_id'])->toArray())->where('nama','like','%'.$q.'%')->get(['members.id'])->toArray())->orWhereIn('book_id',Book::whereIn('id',Borrow::groupBy('book_id')->get(['borrows.book_id'])->toArray())->where('judul','like','%'.$q.'%')->get(['books.id'])->toArray())->get(['borrows.id'])->toArray()))));
			$borrows = Borrow::where('id','like','%'.$q.'%')->orWhere('member_id','like','%'.$q.'%')->orWhere('book_id','like','%'.$q.'%')->orWhere('waktu_pinjam','like','%'.$q.'%')->orWhere('waktu_kembali','like','%'.$q.'%')->orWhere('status','like','%'.$q.'%')->orWhereIn('member_id',Member::whereIn('id',Borrow::groupBy('member_id')->get(['borrows.member_id'])->toArray())->where('nama','like','%'.$q.'%')->get(['members.id'])->toArray())->orWhereIn('book_id',Book::whereIn('id',Borrow::groupBy('book_id')->get(['borrows.book_id'])->toArray())->where('judul','like','%'.$q.'%')->get(['books.id'])->toArray())->groupBy('id')->orderBy('waktu_pinjam','desc')->skip(($page-1)*$perpage)->take(10)->get();
			$details = Borrow::whereIn('id',Borrow::where('id','like','%'.$q.'%')->orWhere('member_id','like','%'.$q.'%')->orWhere('book_id','like','%'.$q.'%')->orWhere('waktu_pinjam','like','%'.$q.'%')->orWhere('waktu_kembali','like','%'.$q.'%')->orWhere('status','like','%'.$q.'%')->orWhereIn('member_id',Member::whereIn('id',Borrow::groupBy('member_id')->get(['borrows.member_id'])->toArray())->where('nama','like','%'.$q.'%')->get(['members.id'])->toArray())->orWhereIn('book_id',Book::whereIn('id',Borrow::groupBy('book_id')->get(['borrows.book_id'])->toArray())->where('judul','like','%'.$q.'%')->get(['books.id'])->toArray())->groupBy('id')->get(['borrows.id'])->toArray())->get();
			$path = './borrow?q='.$q.'&page=';
		}else{
			$total = count(array_map('unserialize',array_unique(array_map('serialize',Borrow::get(['borrows.id'])->toArray()))));
			$borrows = Borrow::groupBy('id')->orderBy('waktu_pinjam','desc')->skip(($page-1)*$perpage)->take(10)->get();
			$details = Borrow::whereIn('id',Borrow::groupBy('id')->get(['borrows.id'])->toArray())->get();
			$path = './borrow?page=';
		}
		$totalpage = ceil($total/$perpage);

		return view('public.borrow', compact('borrows','details','total','page','perpage','totalpage','path'));
	}

	public function getReport(Request $request)
	{
		return view('public.report');
	}

	public function guestBook(Request $request)
	{
		if(\Request::isMethod('post'))
		{
			GuestBook::create([
				'nama' => trim(strip_tags($request->input('nama'))),
				'email' => trim(strip_tags($request->input('email'))),
				'komentar' => trim(strip_tags($request->input('komentar'))),
				'waktu' => new \Datetime,
			]);

			return redirect()->back()->with('message','Terima Kasih '.trim(strip_tags($request->input('nama'))).' atas komentarnya.');
		}else{
			$guests = GuestBook::orderBy('waktu','desc')->get();

			return view('public.guest', compact('guests'));
		}
	}

	public function getData(Request $request,$data = '')
	{
		if($request->has('start') && $request->has('end')){
			if($request->input('id') == 1){
				foreach(DB::table('members')->select(DB::raw('date(waktu) as waktu, count(id) as id'))->whereBetween(DB::raw('date(waktu)'),[trim(strip_tags($request->input('start'))),trim(strip_tags($request->input('end')))])->groupBy(DB::raw('date(waktu)'))->orderBy('waktu','asc')->get() as $key => $member){
					$data[$key]['label'] = str_replace('-','/',$member->waktu);
					$data[$key]['value'] = $member->id;
				}
			}elseif($request->input('id') == 2){
				foreach(DB::table('borrows')->select(DB::raw('date(waktu_pinjam) as waktu_pinjam'))->whereBetween(DB::raw('date(waktu_pinjam)'),[trim(strip_tags($request->input('start'))),trim(strip_tags($request->input('end')))])->groupBy(DB::raw('date(waktu_pinjam)'))->orderBy('waktu_pinjam','asc')->get() as $key => $borrow){
					$data[$key]['label'] = str_replace('-','/',$borrow->waktu_pinjam);
					$data[$key]['value'] = count(array_map('unserialize',array_unique(array_map('serialize',Borrow::where(DB::raw('date(waktu_pinjam)'),'=',$borrow->waktu_pinjam)->get(['borrows.id'])->toArray()))));
				}
			}else{
				foreach(DB::table('books')->select(DB::raw('date(tanggal_masuk) as tanggal_masuk, count(id) as id'))->whereBetween(DB::raw('date(tanggal_masuk)'),[trim(strip_tags($request->input('start'))),trim(strip_tags($request->input('end')))])->groupBy(DB::raw('date(tanggal_masuk)'))->orderBy('tanggal_masuk','asc')->get() as $key => $book){
					$data[$key]['label'] = str_replace('-','/',$book->tanggal_masuk);
					$data[$key]['value'] = $book->id;
				}
			}
		}

		return response()->json($data);
	}

	public function getDetail(Request $request,$data = '')
	{
		if($request->has('id')){
			if($request->input('it') == 1){
				foreach(Member::where('waktu','like',trim(strip_tags(str_replace('/','-',$request->input('id'))).'%'))->orderBy('waktu','asc')->get() as $key => $member){
					$data[$key]['kode'] = $member->id;
					$data[$key]['nama'] = $member->nama;
					$data[$key]['jkel'] = $member->jenis_kelamin == 'perempuan' ? 'Perempuan' : 'Laki-Laki';
					$data[$key]['jang'] = $member->jenis_anggota == 'karyawan' ? 'Karyawan' : 'Non-Karyawan';
					$data[$key]['alam'] = $member->alamat;
					$data[$key]['wakt'] = tanggal($member->waktu);
				}
			}elseif($request->input('it') == 2){
				foreach(Borrow::whereIn('id',array_map('unserialize',array_unique(array_map('serialize',Borrow::where('waktu_pinjam','like',trim(strip_tags(str_replace('/','-',$request->input('id'))).'%'))->orderBy('waktu_pinjam','asc')->get(['borrows.id'])->toArray()))))->groupBy('id')->orderBy('waktu_pinjam','asc')->get() as $key => $borrow){
					$data[$key]['kode'] = $borrow->id;
					$data[$key]['pinj'] = tanggal($borrow->waktu_pinjam);
					$data[$key]['nipn'] = $borrow->member->id;
					$data[$key]['nama'] = $borrow->member->nama;
					$result = '';
					foreach(Borrow::where('id','=',$borrow->id)->get() as $val)
						$result .= '<tr><td width="78px" style="padding:3px;">'.$val->book->id.'</td><td width="385px" style="padding:3px;">'.$val->book->judul.'</td><td width="100px" style="padding:3px;">'.(empty($val->waktu_kembali) ? ' ' : tanggal($val->waktu_kembali)).'</td><td width="124px" style="padding:3px;">'.(empty($val->waktu_kembali) ? 'Peminjaman' : 'Pengembalian').'</td></tr>';
					$data[$key]['buku'] = $result;
				}
			}else{
				foreach(Book::where('tanggal_masuk','like',trim(strip_tags(str_replace('/','-',$request->input('id'))).'%'))->orderBy('tanggal_masuk','asc')->get() as $key => $book){
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
		}elseif($request->has('start') && $request->has('end')){
			if($request->input('it') == 1){
				foreach(Member::whereBetween(DB::raw('date(waktu)'),[trim(strip_tags($request->input('start'))),trim(strip_tags($request->input('end')))])->orderBy('waktu','asc')->get() as $key => $member){
					$data[$key]['kode'] = $member->id;
					$data[$key]['nama'] = $member->nama;
					$data[$key]['jkel'] = $member->jenis_kelamin == 'perempuan' ? 'Perempuan' : 'Laki-Laki';
					$data[$key]['jang'] = $member->jenis_anggota == 'karyawan' ? 'Karyawan' : 'Non-Karyawan';
					$data[$key]['alam'] = $member->alamat;
					$data[$key]['wakt'] = tanggal($member->waktu);
				}
			}elseif($request->input('it') == 2){
				foreach(Borrow::whereIn('id',array_map('unserialize',array_unique(array_map('serialize',Borrow::whereBetween(DB::raw('date(waktu_pinjam)'),[trim(strip_tags($request->input('start'))),trim(strip_tags($request->input('end')))])->orderBy('waktu_pinjam','asc')->get(['borrows.id'])->toArray()))))->groupBy('id')->orderBy('waktu_pinjam','asc')->get() as $key => $borrow){
					$data[$key]['kode'] = $borrow->id;
					$data[$key]['pinj'] = tanggal($borrow->waktu_pinjam);
					$data[$key]['nipn'] = $borrow->member->id;
					$data[$key]['nama'] = $borrow->member->nama;
					$result = '';
					foreach(Borrow::where('id','=',$borrow->id)->get() as $val)
						$result .= '<tr><td width="78px" style="padding:3px;">'.$val->book->id.'</td><td width="385px" style="padding:3px;">'.$val->book->judul.'</td><td width="100px" style="padding:3px;">'.(empty($val->waktu_kembali) ? ' ' : tanggal($val->waktu_kembali)).'</td><td width="124px" style="padding:3px;">'.(empty($val->waktu_kembali) ? 'Peminjaman' : 'Pengembalian').'</td></tr>';
					$data[$key]['buku'] = $result;
				}
			}else{
				foreach(Book::whereBetween(DB::raw('date(tanggal_masuk)'),[trim(strip_tags($request->input('start'))),trim(strip_tags($request->input('end')))])->orderBy('tanggal_masuk','asc')->get() as $key => $book){
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

}
