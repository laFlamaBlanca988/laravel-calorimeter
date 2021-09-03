<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\JsonResponse;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use function PHPUnit\Framework\isEmpty;

class MealsController extends Controller
{
    public function index(): JsonResponse
    {
        $meals = new Meal;
        $userID = Auth::user()->id;
        $latestMeal = $meals->getLatestMeal($userID);
        return response()->json($latestMeal);
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

    public function getLastWeekData(): JsonResponse
    {
        $meals = new Meal;
        $userID = Auth::user()->id;
        $calSum = $meals->getSumOfCalories($userID);
        $lastWeekMeals = $meals->getLastWeekMeals($userID);
        $totalCalories = 0;
        foreach ($lastWeekMeals as $mealsData) {
            $totalCalories += $mealsData->cal_num;
        }

        return response()->json([
            'meals' => $lastWeekMeals,
            "total_calories" => $totalCalories
        ]);
    }
    public function getLastMonthData(): JsonResponse
    {
        $meals = new Meal;
        $userID = Auth::user()->id;
        $lastMonthMeals = $meals->getLastMonthMeals($userID);
        $totalCalories = 0;
        foreach ($lastMonthMeals as $mealsData) {
            $totalCalories += $mealsData->cal_num;
        }

        return response()->json([
            'meals' => $lastMonthMeals,
            "total_calories" => $totalCalories
        ]);
    }

    public function getMealsByDateAndTime(Request $request): JsonResponse
    {
        $meal = new Meal;
        $userID = Auth::user()->id;

        return response()->json( $meal->filterMealsByDateTimeRange($userID, $request->input('fromDate'), $request->input('toDate'), $request->input('fromTime'), $request->input('toTime') ) );






        $fromDate = $request->input('fromDate');
        $meal->toDate = $request->input('toDate');
        $meal->fromTime= $request->input('fromTime');
        $meal->toTime = $request->input('toTime');
//        dd($meal->toTime);
        if(empty($meal->fromTime)){
            dd(555);
        }
        $mealsByDate = $meal->filterMealsByDate($userID, $fromDate, $meal->toDate);
        $mealsByTime = $meal->filterMealsByTime($userID, $meal->fromTime, $meal->toTime);
        return response()->json([$mealsByDate, $mealsByTime]);
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
