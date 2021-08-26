<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\JsonResponse;

class MealsController extends Controller
{
    public function index(): JsonResponse
    {
        $meals = new Meal;
        $userID = Auth::user()->id;
        $latestMeal = $meals->getLatestMeal($userID);

        return response()->json($latestMeal);
    }

    public function create(Request $request)
    {

    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'cal_num' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $meal = new Meal;

            $meal->title = $request->input('title');
            $meal->cal_num = $request->input('cal_num');
            $meal->date = $request->input('date');
            $meal->time = $request->input('time');
            $meal->userID = Auth::user()->id;

            $newRowID = $meal->storeMeal($meal->title, $meal->cal_num, $meal->date, $meal->time, $meal->userID);

            if( $newRowID ) {
                return response()->json([
                    'status' => 200,
                    'id' => $newRowID,
                    'message' => 'Meal added successfully!'
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Something went wrong. Please try again later.'
            ]);
        }
    }

    public function edit(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'cal_num' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $meal = new Meal;

            $meal->title = $request->input('title');
            $meal->cal_num = $request->input('cal_num');
            $meal->date = $request->input('date');
            $meal->time = $request->input('time');
            $meal->userID = Auth::user()->id;
            $mealID= $request->json()->get('id');

            $editRowID = $meal->editMeal($mealID ,$meal->title, $meal->cal_num, $meal->date, $meal->time, $meal->userID);

            if( $editRowID ) {
                return response()->json([
                    'status' => 200,
                    'id' => $mealID,
                    'message' => 'Meal edited successfully!'
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Something went wrong. Please try again later.'
            ]);
       }
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request): JsonResponse
    {
        $meals = new Meal;
        $mealID= $request->json()->all();
        if( $meals->deleteMeal($mealID) ) {
            return response()->json([
                'status' => '200',
                'message' => "Meal is successfully deleted."
            ]);

        } else {
            return response()->json([
                'status' => '400',
                'message' => "Something went wrong. Please try again."
            ]);
        }
    }
};
