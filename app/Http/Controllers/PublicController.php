<?php namespace App\Http\Controllers;

use Response;
use App\Model\Book;
use App\Model\File;
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
		return view('index');
	}

	public function getDownload($file)
	{
		$files = File::where('sha1sum','=',$file)->get(['files.filename']);

		if(count($files) > 0)
		{
			if(\File::exists(public_path('files/').$files[0]->filename))
			{
				return Response::download((public_path('files/').$files[0]->filename), $files[0]->filename, ['Content-Type' => 'application/pdf']);
			}
		}
	}

	public function getBook($jenis)
	{
		$books = Book::where('jenis','=',strtoupper($jenis))->orderBy('created_at','desc')->paginate(15);
		$books->setPath('../buku/'.$jenis);

		return view('buku', compact('jenis','books'));
	}

}
