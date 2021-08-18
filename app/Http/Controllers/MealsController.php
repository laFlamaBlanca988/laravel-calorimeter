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
            'cal_num' => 'required|max:191',
            'date' => 'required|max:191',
            'time' => 'required|max:191',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $meal = new Meal;

            $meal->title = $request->input('title');
            $meal->cal_num = $request->input('cal_num');
            $meal->date = $request->input('date');
            $meal->time = $request->input('time');
            $meal->userID = Auth::user()->id;

            $meal->storeMeal($meal->title, $meal->cal_num, $meal->date, $meal->time, $meal->userID);
            return response()->json([
                'status' => 200,
                'message' => 'Meal added successfully!',
            ]);
        }

    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {

    }
}
