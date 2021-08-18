<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{

    public function index()
    {
        $meals = new Meal;
        $userID =  Auth::user()->id;
        $userMeals = $meals->getMealsForUser($userID);

        return view('pages.welcome', [
            'meals' => $userMeals,
        ]);
    }

    public function show($id): string
    {
        return "hello";
    }
}
