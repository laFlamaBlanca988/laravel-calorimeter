<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
        public function index($id): JsonResponse
        {
            $meals = new Meal;
            $userID = $id;
            $userMeals = $meals->apiGetUserMeals($userID);
            $mealCount = count($userMeals);
            return response()->json([
                'meal_count' => $mealCount,
                'data' => $userMeals
            ]);
        }
}
