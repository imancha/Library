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
			'email' => 'required',
			'password' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);

		if($validator->fails()){
			return redirect()->back()->withErrors($validator->messages());
		}else{
			if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
				if(Auth::user()->status == 'kabag')
					return new RedirectResponse(url('/administrator'));
				else
					return new RedirectResponse(url('/admin'));
			}else{
				return redirect()->back()->withErrors('These credentials do not match our records.');
			}
		}
	}

	public function update(Request $request)
	{
		if(Auth::check()){
			$validator = Validator::make(
				[
					'id' => $request->user()->id,
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
					$user = User::find($request->user()->id);
					$user->name = trim(strip_tags($request->input('name')));
					$user->email = trim(strip_tags($request->input('email')));
					if($request->has('new'))
						$user->password = bcrypt(trim(strip_tags($request->input('new'))));
					$user->save();

					return redirect()->back()->with('message', 'Account berhasil disimpan.');
				}else{
					return redirect()->back()->withErrors($validator->getMessageBag()->add('password', 'Invalid password'));
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
