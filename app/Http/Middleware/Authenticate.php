<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('/login');
			}
		}
		else
		{
			if($this->auth->user()->status == 'kabag')
			{
				$route = explode('/', $request->route()->uri());

				if($route[0] == 'admin')
				{
					if ($request->ajax())
					{
						return response('Unauthorized.', 401);
					}
					else
					{
						return redirect()->guest('/administrator');
					}
				}
			}
			elseif($this->auth->user()->status == 'staff')
			{
				$route = explode('/', $request->route()->uri());

				if($route[0] == 'administrator')
				{
					if($request->ajax())
					{
						return response('Unauthorized.', 401);
					}
					else
					{
						return redirect()->guest('/admin');
					}
				}
			}
		}

		return $next($request);
	}

}
