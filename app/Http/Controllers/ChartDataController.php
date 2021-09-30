<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartDataController extends Controller
{
    public function getCaloriesConsumptionData(Request $request): JsonResponse
    {
        $allMeals = new Meal;
        $userID = Auth::user()->id;
        $dateFrom = $request->input('startDate');
        $dateTo = $request->input('endDate');
        $dateCal = $allMeals->getSumOfCaloriesByDateRange($userID,$dateFrom, $dateTo);

        return response()->json([
            "result" => $dateCal
            ]);
    }
}
