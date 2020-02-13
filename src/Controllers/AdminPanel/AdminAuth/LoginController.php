<?php

namespace App\Http\Controllers\AdminPanel\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    public $request;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('admin.guest', ['except' => 'logout']);
        $this->request = $request;
    }

    public function showLoginForm(){
        return view('admin.login3');
    }

    public function logoutToPath(){
        return '/admin';
    }

    protected function validateLogin(Request $request){
        $validate = [
            'password' => 'required|string',
        ];
        
        $username = $request->username;
        if(filter_var($username,FILTER_VALIDATE_EMAIL)){
            $validate['username'] = 'required|email|string';
        }else{
            $validate['username'] = 'required|regex:/^[a-zA-Z0-9_]+$/|string';
        }

        $request->validate($validate);
    }

    protected function credentials(Request $request){
        return $request->only('username', 'password');
    }

    public function username(){
        $username = $this->request->username;
        if(filter_var($username,FILTER_VALIDATE_EMAIL)){
            $field = 'email';
        }else{ $field = 'username'; }

        return $field;
    }

    protected function sendFailedLoginResponse(Request $request){
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function attemptLogin(Request $request){
        $username = $request->username;
        $password = $request->password;

        if(filter_var($username,FILTER_VALIDATE_EMAIL)){
            return $attempt = $this->guard()->attempt(['email'=>$username, 'password'=>$password, 'disable'=>0]);
        }else{
            return $attempt = $this->guard()->attempt(['username'=>$username, 'password'=>$password, 'disable'=>0]);
        }
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
