<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Doctrine\DBAL\Portability\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{
        public function readMeals($id): JsonResponse
        {
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
                    'message' => 'Authentication failed'
                ], 403);
            }
        }
        public function deleteMeals(Request $request, $id): JsonResponse
        {
            $meals = new Meal;
            $userMeals = $meals->apiGetMealsForUser(auth()->id());
            foreach ($userMeals as $meal) {
                if ($meal->id == $id && $meals->apiDeleteUserMeals($id)) {

                    return response()->json(['status' => '200', 'message' => "Meal is successfully deleted."]);
                } else {
                    return response()->json([
                        'message' => 'Wrong credentials'
                    ]);
                }
            }
                return response()->json([
                    'status' => '400',
                    'message' => "Something went wrong. Please try again ."
                ]);
        }

    public function editMeals(Request $request, $id): JsonResponse
    {

        $validator = Validator::make($request->json()->all(), [
            'title' => 'required|max:50',
            'cal_num' => 'required|digits_between:1,9',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i:s'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()->first()
            ]);
        } else {
            $meal = new Meal;
            $userID = $request->json()->get('userID');
            $title = $request->json()->get('title');
            $cal_num = $request->json()->get('cal_num');
            $date = $request->json()->get('date');
            $time = $request->json()->get('time');
            $mealID= $request->json()->get('id');
            $editRowID = $meal->editMeal($mealID ,$title, $cal_num, $date, $time);
            if($mealID == $id && $userID == auth()->id() && ($editRowID  || $editRowID == 0)) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Meal edited successfully!'
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Wrong credentials!'
                ]);
            }
        }
    }
}
