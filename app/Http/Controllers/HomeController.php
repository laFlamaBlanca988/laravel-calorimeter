<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        $meals = new Meal;
        $data = $meals->getMealsForUser(Auth::user()->id);
        $totalCalories = 0;
        foreach ($data as $mealsData) {
            $totalCalories += $mealsData->cal_num;
        }
        return view('pages.home', [
            'data' => $data,
            'totalCalories' => $totalCalories
        ]);
    }
    public function fetch_data(Request $request): string
    {
        if($request->ajax()){
            $meals = new Meal;
            $data = $meals->getMealsForUser(Auth::user()->id);
            return view('pages.tableHome', compact('data'))->render();
        }
        return response()->json([
            'status' => 400,
            'message' => 'Something went wrong. Please try again later.'
        ]);
    }
}
