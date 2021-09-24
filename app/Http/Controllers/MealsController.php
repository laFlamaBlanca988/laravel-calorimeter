<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'title' => 'required|max:50',
            'cal_num' => 'required|digits_between:1,9',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()->first()
            ]);
        } else {
            $meal = new Meal;
            $title = $request->input('title');
            $cal_num = $request->input('cal_num');
            $date = $request->input('date');
            $time = $request->input('time');
            $userID = Auth::user()->id;

            $newRowID = $meal->storeMeal($title, $cal_num, $date, $time, $userID);

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
            $title = $request->input('title');
            $cal_num = $request->input('cal_num');
            $date = $request->input('date');
            $time = $request->input('time');
            $mealID= $request->json()->get('id');
            $editRowID = $meal->editMeal($mealID ,$title, $cal_num, $date, $time);

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
        $lastWeekMeals = $meals->getLastWeekMeals($userID);
        $totalCalories = 0;
        foreach ($lastWeekMeals as $mealsData) {
            $totalCalories += $mealsData->cal_num;
        }

        return response()->json([
            "meals" => $lastWeekMeals,
            "totalCalories" => $totalCalories
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
            "totalCalories" => $totalCalories
        ]);
    }

    public function getMealsByDateAndTime(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'dateFrom' => 'date_format:Y-m-d',
            'dateTo' => 'date_format:Y-m-d',
            'timeFrom' => 'date_format:h:i',
            'timeTo' => 'date_format:h:i'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->messages()->first()]);
        } else {
            $meal = new Meal;
            $userID = Auth::user()->id;
            $dateFrom = $request->input('fromDate');
            $dateTo = $request->input('toDate');
            $timeFrom = $request->input('fromTime');
            $timeTo = $request->input('toTime');
            $mealsFilterAll = $meal->filterMealsByDateTimeRange($userID, $dateFrom, $dateTo, $timeFrom, $timeTo);
            $totalCalories = 0;
            foreach ($mealsFilterAll as $mealsData) {
                $totalCalories += $mealsData->cal_num;
            }
            return response()->json(["mealsFilterAll" => $mealsFilterAll, "totalCalories" => $totalCalories]);
        }
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
