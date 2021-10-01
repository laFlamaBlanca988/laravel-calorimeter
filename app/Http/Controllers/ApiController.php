<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ApiController extends Controller
{
        public function index(Request $request, $id): JsonResponse
        {
            $authHeader = $request->header('Authorization');
            $userPass =explode(' ', $authHeader.'')[1];
            $meals = new Meal;
            $userMeals = $meals->apiGetUserMeals($id);
            $mealCount = count($userMeals);

                return response()->json([
                    'meal_count' => $mealCount,
                    'data' => $userMeals
                ]);
        }
}
