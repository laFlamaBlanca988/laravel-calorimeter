<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index()
    {
        $meals = new Meal;
        $userID =  Auth::user()->id;
        $userMeals = $meals->getMealsForUser($userID);
        $totalCalories = 0;
        foreach ($userMeals as $mealsData) {
            $totalCalories += $mealsData->cal_num;
        }
        return view('admin.admin', [
            'meals' => $userMeals,
            'totalCalories' => $totalCalories
        ]);
    }
}
