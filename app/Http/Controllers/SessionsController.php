<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    /**
     * @throws ValidationException
     */
    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($attributes)) {
            if(Auth::user()->role_id === 3) {
                return redirect('/welcome')->with('success', 'You are now logged in!');
            } else {
                return redirect('/admin')->with('success', 'You are now logged in!');
            }
        }

        throw ValidationException::withMessages([
            'email' => 'Provided credentials could not be verified.',
        ]);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect(route('home'))->with('success', 'Goodbye!');
    }
}
