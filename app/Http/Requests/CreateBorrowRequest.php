<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateBorrowRequest extends Request {

	/**
	 * The URI to redirect to if validation fails
	 *
	 * @var string
	 */
	protected $redirect = 'admin/borrow/create';

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
			'idp'		=>	'required|min:2|',
			'id'		=>	'required|min:3|numeric',
			'nama'	=>	'required|min:3|alay',
			'kode'	=>	'required|min:1',
			'judul'	=>	'required|min:3',
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
