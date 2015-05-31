<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateSliderRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'judul' => 'required|min:3',
			'keterangan'	=>	Request::has('keterangan') ? 'min:3|max:255' : '',
			'file'	=>	'mimes:jpg,jpeg,png,gif',
		];
	}

}
