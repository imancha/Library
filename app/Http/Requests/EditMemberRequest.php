<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditMemberRequest extends Request {

	public function __construct() {
		$this->validator = app('validator');
		$this->validateAlay($this->validator);
	}

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
			'id'					=>	'required|numeric|min:3|exists:members,id',
			'nama'				=>	'required|min:3|alay',
			'lahir'				=>	Request::has('lahir') ? 'min:3|max:255' : '',
			'jk'					=>	'required',
			'ja'					=>	'required',
			'phone'				=>	is_numeric(Request::input('phone')) ? 'string|min:8|max:12' : 'numeric',
			'alamat'			=>	Request::has('alamat') ? 'min:3|max:255' : '',
			'keterangan'	=>	Request::has('keterangan') ? 'min:3|max:255' : '',
		];
	}

	public function messages()
	{
		return [
			'nama.alay'	=>	'The :attribute may only contain letters.',
		];
	}

	public function validateAlay($validator) {
		$validator->extend('alay', function($attribute, $value, $parameters) {
			return !is_alay($value);
		});
	}

}
