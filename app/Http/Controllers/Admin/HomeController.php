<?php namespace App\Http\Controllers\Admin;

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
		$member = service('member');
		$borrow = service('borrow');

		return view('admin.index', compact('guests','sliders','beranda','member','borrow'));
	}

	public function getData($data = '')
	{
		if(Request::has('start') && Request::has('end'))
		{
			foreach(Book::whereBetween('tanggal_masuk',[Request::input('start'),Request::input('end')])->groupBy('tanggal_masuk')->orderBy('tanggal_masuk','asc')->get(['books.tanggal_masuk']) as $key => $book)
			{
				$data[$key]['label'] = str_replace('-','/',$book['tanggal_masuk']);
				$data[$key]['value'] = Book::where('tanggal_masuk','=',$book['tanggal_masuk'])->count();
			}
		}

		echo json_encode($data);
	}

	public function postAddress()
	{
		$result = \File::put(public_path('/inc/').(Request::input('id') == 1 ? 'location' : 'address'), Request::input('txt'));
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
		if(Request::input('id') == 1)
		{
			$result = Book::join('borrows', function($join){
				$join->on('borrows.book_id','=','books.id')->where('borrows.status','like','%pinjam%')->where('borrows.member_id','=',Request::input('id1'));
			})->get(['borrows.id','borrows.book_id','books.judul','borrows.tanggal_pinjam']);
		}else{
			$result = Member::join('borrows', function($join){
				$join->on('borrows.member_id','=','members.id')->where('borrows.status','like','%pinjam%')->where('borrows.book_id','=',Request::input('id2'));
			})->get(['borrows.id','borrows.book_id','borrows.member_id','members.nama','borrows.tanggal_pinjam']);
		}

		return response()->json($result);
	}

	public function postDashboard()
	{
		if(Request::hasFile('img'))
		{
			$path = public_path('/');
			$file = Request::file('img');

			$validator = Validator::make(
				['image' => $file], ['image' => 'mimes:jpg,jpeg,png,gif']
			);

			if($validator->fails())
			{
				return redirect()->back()->withErrors($validator->messages());
			}else{
				$name = $file->getClientOriginalName();
				$mime = $file->getClientOriginalExtension();
				$fiel = $path.$name;

				if(\File::exists($path.Request::input('_file'))) \File::delete($path.Request::input('_file'));
				if(\File::exists($fiel)) \File::delete($fiel);

				if($file->move($path,$name))
					$img = '<img id="img" src="./'.$name.'" class="img img-responsive" alt="'.$name.'" width="200px" height="200px" style="float:right;display:inline;margin:10px 0 10px 10px;">';
			}
		}else{
			$img = '<img id="img" src="./'.Request::input('_file').'" class="img img-responsive" alt="'.Request::input('_file').'" width="200px" height="200px" style="float:right;display:inline;margin:15px 0 10px 10px;">';
		}

		$result = \File::put(public_path('/inc/welcome'),'<h3 id="title" style="margin-top:5px;">'.Request::input('title').'</h3>'.$img.'<div id="post" style="margin-top:20px">'.Request::input('post').'</div>');

		if($result === false) die("Error writing to file");

		return redirect()->back()->with('message','Beranda Control berhasil disimpan.');
	}

	public function postService($id)
	{
		$result = \File::put(public_path('/inc/'.$id), Request::input($id));

		if($result === false) die("Error writing to file");

		return redirect()->back()->with('message',Request::input('_id').' berhasil disimpan.');
	}

	public function guestBook()
	{
		GuestBook::where('id','=',Request::input('id'))->delete();

		return redirect()->back()->with('message','Komentar dari '.Request::input('nama').' berhasil dihapus');
	}

}
