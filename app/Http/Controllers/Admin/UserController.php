<?php namespace App\Http\Controllers\Admin;

use Auth;

use Validator;

use App\User;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UserController extends Controller {

	public function update(Request $request)
	{
		if(Auth::check())
		{
			$validator = Validator::make(
				[
					'id' => $request->user()->id,
					'name' => $request->input('nama'),
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

			if($validator->fails())
			{
				return redirect()->back()->withErrors($validator->messages());
			}
			else
			{
				if(Auth::attempt(['password' => $request->input('password')]))
				{
					$user = User::find($request->user()->id);
					$user->name = trim(strip_tags($request->input('nama')));
					$user->email = trim(strip_tags($request->input('email')));
					if($request->has('new'))
						$user->password = bcrypt(trim(strip_tags($request->input('new'))));
					$user->save();

					return redirect()->back()->with('message', 'Account berhasil disimpan.');
				}
				else
				{
					return redirect()->back()->withErrors($validator->getMessageBag()->add('password', 'Invalid password'));
				}
			}
		}
	}
}
