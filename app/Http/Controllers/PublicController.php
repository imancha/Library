<?php namespace App\Http\Controllers;

use DB;
use Response;
use App\Model\Author;
use App\Model\Book;
use App\Model\BookAuthor;
use App\Model\File;
use App\Model\Publisher;
use App\Model\Subject;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PublicController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	private $perpage = 15;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$book = Book::count();
		$books = Book::orderBy('created_at','desc')->take(10)->get();
		return view('index',compact('book','books'));
	}

	public function getDownload($file)
	{
		$file = File::where('sha1sum','=',$file)->first();
		if(\File::exists(public_path('files/').$file->filename.'.'.$file->mime))
			return Response::download((public_path('files/').$file->filename.'.'.$file->mime), $file->filename.'.'.$file->mime, ['Content-Type' => 'application/pdf']);
	}

	public function getBook(Request $request, $jenis='')
	{
		if(empty($jenis))
		{
			if($request->has('q'))
			{
				$q = $request->input('q');
				$books = Book::where('id','like','%'.$q.'%')->orWhere('judul','like','%'.$q.'%')->orWhere('edisi','like','%'.$q.'%')->orWhere('jenis','like','%'.$q.'%')->orWhereIn('id',BookAuthor::whereIn('author_id',Author::where('nama','like','%'.$q.'%')->get(['authors.id'])->toArray())->get(['book_id'])->toArray())->orWhereIn('publisher_id',Publisher::where('nama','like','%'.$q.'%')->get(['publishers.id'])->toArray())->orWhereIn('subject_id',Subject::where('nama','like','%'.$q.'%')->get(['subjects.id'])->toArray())->orderBy('created_at','desc')->paginate($this->perpage);
				$books->setPath('./book^q='.$q);
				$jenis = $q;
			}else{
				$books = Book::orderBy('created_at','desc')->paginate(15);
				$books->setPath('./book');
				$jenis = 'Koleksi Buku';
			}
		}elseif($jenis == 'asli' || $jenis == 'pkl'){
			$books = Book::where('jenis','like',$jenis)->orderBy('created_at','desc')->paginate($this->perpage);
			$books->setPath('../book/'.$jenis);
			$jenis = ($jenis == 'asli' ? 'Buku Asli' : 'Buku PKL');
		}else{
			$books = Book::where('subject_id','=',Subject::where('nama','like',str_replace('+',' ',$jenis))->get(['subjects.id'])->toArray())->orderBy('created_at','desc')->paginate($this->perpage);
			$books->setPath('../book/'.$jenis);
			$jenis = ucwords(str_replace('+',' ',$jenis));
		}
		$subjects = Subject::orderBy('nama','asc')->get();

		return view('book', compact('jenis','subjects','books'));
	}

}
