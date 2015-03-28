<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateBorrowRequest extends Request {

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
			'idp'		=>	'required|min:2|unique:borrows,id',
			'id'		=>	'required|min:3|numeric',
			'nama'	=>	'required|min:3',
			'kode'	=>	'required|min:1',
			'judul'	=>	'required|min:3',
		];
	}

	public function messages()
	{
		return [
			//
		];
	}

	/**
	 * The URI to redirect to if validation fails
	 *
	 * @var string
	 */
	protected $redirect = 'admin/borrow/create';

}
