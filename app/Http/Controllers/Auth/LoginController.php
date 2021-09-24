<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo(): string
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($attributes)) {
            switch (Auth::user()->role) {
                case 'admin':
                    $this->redirectTo = '/admin';
                    return $this->redirectTo;
                    break;
                case 'manager':
                    $this->redirectTo = '/manager';
                    return $this->redirectTo;
                    break;
                case 'user':
                    $this->redirectTo = '/home';
                    return $this->redirectTo;
                    break;
                default:
                    $this->redirectTo = '/login';
                    return $this->redirectTo;
            }
        }

        // return $next($request);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest');
    }

    public function loggedOut()
    {
        auth()->logout();
        return redirect(route('login'))->with('success', 'Goodbye!');
    }
}
