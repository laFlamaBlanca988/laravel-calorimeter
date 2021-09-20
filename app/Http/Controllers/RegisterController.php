<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{

    public function index()
    {
        return view('auth.register');
    }

    public function store()
    {
//        dd(Request::capture());
        // create the user
        $attributes = request()->validate([
            'name' => ['required', 'max:255'],
            'username' => ['required', 'max:255', 'min:3', Rule::unique('users', 'username')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'min:4', 'max:255']]);

       $user =  User::create($attributes);
        auth()->login($user);
        return redirect('home')->with('success', 'Your account has been created!');
    }
}
