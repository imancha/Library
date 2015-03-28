<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateMemberRequest extends Request {

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
			'id'					=>	'required|numeric|min:3|unique:members,id',
			'nama'				=>	'required|min:3',
			'tanggal'			=>	'required|digits_between:1,31',
			'bulan'				=>	'required|digits_between:1,12',
			'tahun'				=>	'required|digits:4',
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
			//
		];
	}

	/**
	 * The URI to redirect to if validation fails
	 *
	 * @var string
	 */
	protected $redirect = 'admin/member/create';

}
