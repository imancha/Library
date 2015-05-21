<?php namespace App\Http\Controllers;

use App\Model\Author;
use App\Model\Book;
use App\Model\BookAuthor;
use App\Model\File;
use App\Model\GuestBook;
use App\Model\Publisher;
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

		return view('public.index',compact('book','asli','pkl','sliders','beranda'));
	}

	public function getDownload($file)
	{
		$file = File::where('sha1sum','=',$file)->first();
		if(\File::exists(public_path('files/').$file->book_id.' - '.$file->book->judul.'.'.$file->mime))
			return response()->download((public_path('files/').$file->book_id.' - '.$file->book->judul.'.'.$file->mime), $file->book_id.' - '.$file->book->judul.'.'.$file->mime, ['Content-Type' => 'application/pdf']);
	}

	public function getBook(Request $request, $jenis='')
	{
		if(empty($jenis))
		{
			if($request->has('q'))
			{
				$q = trim(strip_tags($request->input('q')));
				$books = Book::where('id','like','%'.$q.'%')->orWhere('judul','like','%'.$q.'%')->orWhere('tahun','like','%'.$q.'%')->orWhere('jenis','like','%'.$q.'%')->orWhereIn('id',BookAuthor::whereIn('author_id',Author::where('nama','like','%'.$q.'%')->get(['authors.id'])->toArray())->get(['book_id'])->toArray())->orWhereIn('publisher_id',Publisher::where('nama','like','%'.$q.'%')->get(['publishers.id'])->toArray())->orWhereIn('subject_id',Subject::where('nama','like','%'.$q.'%')->get(['subjects.id'])->toArray())->orderBy('tanggal_masuk','desc')->paginate(15);
				$books->setPath('./book^q='.$q);
				$title = $q;
			}else{
				$books = Book::orderBy('tanggal_masuk','desc')->paginate(15);
				$books->setPath('./book');
				$title = 'Koleksi Buku';
			}
		}elseif($jenis == 'original' || $jenis == 'research'){
			$jenis = $jenis == 'original' ? 'asli' : 'pkl';
			$books = Book::where('jenis','like',$jenis)->orderBy('tanggal_masuk','desc')->paginate(15);
			$books->setPath('../book/'.$jenis);
			$title = ($jenis == 'asli' ? 'Buku Asli' : 'Buku PKL');
		}elseif($jenis == 'download'){
			$books = Book::has('file')->orderBy('tanggal_masuk','desc')->paginate(15);
			$title = 'Download Buku';
		}else{
			$books = Book::where('subject_id','=',Subject::where('nama','like',str_replace('+',' ',$jenis))->get(['subjects.id'])->toArray())->orderBy('tanggal_masuk','desc')->paginate(15);
			$books->setPath('../book/'.$jenis);
			$title = ucwords(str_replace('+',' ',$jenis));
		}
		$subjects = Subject::orderBy('nama','asc')->get();

		return view('public.book', compact('jenis','subjects','books','title'));
	}

	public function getService($id)
	{
		$service = service($id);
		$id = $id == 'member' ? 'Keanggotaan' : 'Peminjaman';

		return view('public.service', compact('service','id'));
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

			return view('public.guest',compact('guests'));
		}
	}

}
