<?php namespace App\Http\Controllers\Admin;

use App\Model\Slider;
use App\Http\Requests;
use App\Http\Requests\CreateSliderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateSliderRequest $request)
	{
		DB::beginTransaction();

		$slider = new Slider;
		$slider->judul = trim(strip_tags($request->input('judul')));
		$slider->keterangan = trim(strip_tags($request->input('keterangan')));
		$slider->mime = $request->hasFile('file') ? $request->file('file')->getClientOriginalExtension() : '';
		$slider->save();

		if($request->hasFile('file'))
		{
			$path = public_path('img/');
			$name = 'slide-'.$slider->id;
			$mime = $request->file('file')->getClientOriginalExtension();
			$file = $path.$name.'.'.$mime;

			if(\File::exists($file)) \File::delete($file);

			if($request->file('file')->move($path,$name.'.'.$mime))
				DB::commit();
			else
				DB::rollback();
		}else{
			DB::commit();
		}

		return redirect()->back()->with('message','Slider berhasil disimpan.');
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
	public function update(CreateSliderRequest $request, $id)
	{
		$slider = Slider::find($id);

		if($request->hasFile('file'))
		{
			$path = public_path('img/');
			$name = 'slide-'.$id;
			$mime = $request->file('file')->getClientOriginalExtension();
			$file = $path.$name.'.'.$mime;

			if(\File::exists($file)) \File::delete($file);

			if($request->file('file')->move($path,$name.'.'.$mime)) $slider->mime = $mime;
		}

		$slider->judul = trim(strip_tags($request->input('judul')));
		$slider->keterangan = trim(strip_tags($request->input('keterangan')));
		$slider->save();

		return redirect()->back()->with('message','Slider berhasil disimpan.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$slider = Slider::find($id);
		$file = public_path('img/slide-').$slider->id.'.'.$slider->mime;

		if(\File::exists($file)) \File::delete($file);

		$slider->delete();

		return redirect()->back()->with('message','Slider berhasil dihapus.');
	}

}
