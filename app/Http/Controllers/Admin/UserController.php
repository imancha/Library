<?php namespace App\Http\Controllers\Admin;

use Auth;
use Validator;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller {

	public function getRegister()
	{
		return view('user.register');
	}

	public function postRegister(Request $request)
	{
		$rules = [
			'name' => 'required|min:3',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed|min:5',
		];

		$validator = Validator::make($request->all(), $rules);

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator->messages());
		}else{
			User::create([
				'name' => trim(strip_tags($request->input('name'))),
				'email' => trim(strip_tags($request->input('email'))),
				'password' => bcrypt($request->input('password')),
			]);

			return redirect()->back()->withMessage('Register succesfully. Please login.');
		}

	}

	public function getLogin()
	{
		return view('user.login');
	}

	public function postLogin(Request $request)
	{
		$rules = [
			'email' => 'required|email',
			'password' => 'required',
		];

		$messages = [
			'email.required' => 'Email harus diisi.',
			'email.email' => 'Email harus berupa alamat email.',
			'password.required' => 'Password harus diisi.',
		];

		$validator = Validator::make($request->all(), $rules, $messages);

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator);
		}else{
			if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
				return new RedirectResponse(url('/admin'));
			else
				return redirect()->back()->withInput()->withErrors('Email dan password tidak cocok.');
		}
	}

	public function postUpdate(Request $request)
	{
		if(Auth::check()){
			$validator = Validator::make(
				[
					'id' => $request->input('_id'),
					'name' => $request->input('name'),
					'email' => $request->input('email'),
					'password' => $request->input('password'),
					'new' => $request->input('new'),
				],
				[
					'id' => 'required|exists:users,id',
					'name' => 'required|min:3',
					'password' => 'required|min:5',
					'email' => 'required|email',
					'new' => $request->has('new') ? 'required|min:5' : ''
				]
			);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator->messages());
			}else{
				if(Auth::attempt(['password' => $request->input('password')])){
					$user = User::find(trim(strip_tags($request->input('_id'))));
					$user->name = trim(strip_tags($request->input('name')));
					$user->email = trim(strip_tags($request->input('email')));
					$user->status = trim(strip_tags($request->input('status')));
					if($request->has('new'))
						$user->password = bcrypt(trim(strip_tags($request->input('new'))));
					$user->save();

					return redirect()->back()->with('message', 'Account berhasil disimpan.');
				}else{
					return redirect()->back()->withErrors($validator->getMessageBag()->add('password', 'Password salah.'));
				}
			}
		}
	}

	public function getLogout()
	{
		Auth::logout();

		return new RedirectResponse(url('/'));
	}

}
