<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateBookRequest extends Request {

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
			'id'					=>	is_numeric(Request::input('jenis')) ? 'required|numeric|min:1|unique:books,id' : 'required|alpha_num|min:1|unique:books,id',
			'judul'				=>	'required|min:3|max:255',
			'pengarang'		=>	'required|min:3|max:255',
			'penerbit'		=>	'required|min:3|max:255',
			'edisi'				=>	'required|digits:4',
			'subyek'			=>	'required|min:3',
			'rak'					=>	'required|min:3',
			'keterangan'	=>	Request::has('keterangan') ? 'min:3|max:255' : '',
			'file'				=>	is_numeric(Request::input('id')) ? '' : 'required|mimes:pdf',
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
	protected $redirect = 'admin/book/create';

}
