<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class RedirectIfNotAdmin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'admin')
	{
	    if (!Auth::guard($guard)->check()) {
	        return redirect('admin/login');
		}
		
		$admin = Auth::guard($guard)->user();

		// check if admin is disabled
		if($admin->disable == 1){
			Auth::guard($guard)->logout();
			return redirect('admin/login');
		}
		// check if role is disabled
		$roles = $admin->roles()->where('disable',1)->count();
		if($roles){
			Auth::guard($guard)->logout();
			return redirect('admin/login');
		}

		View::share('admin',$admin);

	    return $next($request);
	}
}