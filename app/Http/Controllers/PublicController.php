<?php namespace App\Http\Controllers;

use App\Model;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PublicController extends Controller {

	public function getIndex()
	{
		return view('welcome');
	}

	public function getDownload($file)
	{
		$files = Model\File::where('sha1sum','=',$file)->get(['files.filename']);

		if(count($files) > 0)
		{
			if(\File::exists(public_path('files/').$files[0]->filename))
			{
				return \Response::download((public_path('files/').$files[0]->filename), $files[0]->filename, ['Content-Type' => 'application/pdf']);
			}
		}

	}

}
