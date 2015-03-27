<?php namespace App\Http\Controllers;

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
		return \Response::download((public_path('files').'/'.$file), $file, ['Content-Type' => 'application/pdf']);
	}

}
