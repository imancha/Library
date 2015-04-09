<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditBookRequest extends Request {

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
			'jenis'				=>	'required',
			'id'					=>	is_numeric(Request::input('jenis')) ? 'required|numeric|min:1|exists:books,id' : 'required|alpha_num|min:1|exists:books,id',
			'judul'				=>	'required|min:3|max:255',
			'pengarang'		=>	'required|min:3|max:255|alay',
			'penerbit'		=>	'required|min:3|max:255',
			'edisi'				=>	'required|digits:4',
			'subyek'			=>	'required|min:3',
			'rak'					=>	'required|min:3',
			'keterangan'	=>	Request::has('keterangan') ? 'min:3|max:255' : '',
			'file'				=>	Request::has('file') ? 'mimes|pdf,doc,docx' : '',
		];
	}

	public function messages()
	{
		return [
			'pengarang.alay'	=>	'The :attribute may only contain letters.',
		];
	}

	public function validateAlay($validator) {
		$validator->extend('alay', function($attribute, $value, $parameters) {
			return !is_alay($value);
		});
	}

}