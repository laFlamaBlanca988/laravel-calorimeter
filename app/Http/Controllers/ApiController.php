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
//            $userPass =explode(' ', $authHeader.'')[1];
            $userID = auth()->id();
            $meals = new Meal;
            $userMeals = $meals->apiGetUserMeals($id);
            $mealCount = count($userMeals);
            if($id == $userID) {
                return response()->json([
                    'meal_count' => $mealCount,
                    'data' => $userMeals
                ]);
            }else {
                return response()->json([
                    'message' => 'Auth failed'
                ], 403);
            }
        }
}
