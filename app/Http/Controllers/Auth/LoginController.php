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
        $attributes = request()->validate(['email' => 'required|email', 'password' => 'required',]);

        if (auth()->attempt($attributes)) {
            switch (Auth::user()->role_id) {
                case 1:
                    $this->redirectTo = '/admin';
                    return $this->redirectTo;
                    break;
                case 2:
                    $this->redirectTo = '/manager';
                    return $this->redirectTo;
                    break;
                case 3:
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

    public function destroy()
    {
        auth()->logout();

        return redirect(route('login'))->with('success', 'Goodbye!');
    }
}
