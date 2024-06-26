<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Meal extends Model
{
    use HasFactory;

    protected $table = 'meals';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'cal_num',
        'date',
        'time',
    ];


    /**
     *
     * @param $title
     * @param $cal_num
     * @param $date
     * @param $time
     * @param $userID
     * @return LengthAwarePaginator
     */

    public function getAllMeals(): LengthAwarePaginator
    {
        return DB::table('meals')
            ->join('users', 'users.id', '=', 'meals.userID')
            ->select('meals.*', 'users.name')
            ->paginate(5);
    }

    public function storeMeal($title, $cal_num, $date, $time, $userID): int
    {
        return DB::table('meals')->insertGetId([
            'title' => $title,
            'cal_num' => $cal_num,
            'date' => $date,
            'time' => $time,
            'userID' => $userID,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getMealsForUser($userID): LengthAwarePaginator
    {
       return  DB::table('meals')
           ->select('*')
           ->where('userID','=', $userID)
           ->paginate(4);
    }

    public function getLatestMeal($userID): Collection
    {
        return DB::table('meals')
            ->select('*')
            ->where('userID', '=', $userID)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get();
    }

    public function deleteMeal($mealID): int
    {
      return DB::table('meals')
          ->where('id', '=', $mealID)
          ->delete();
    }

    public function editMeal ($id, $title, $cal_num, $date, $time): int
    {
        return DB::table('meals')
            ->where('id', '=', $id)
            ->update([
            'title' => $title,
            'cal_num' => $cal_num,
            'date' => $date,
            'time' => $time,
        ]);
    }

    public function getLastWeekMeals ($userID): LengthAwarePaginator
    {
        return DB::table('meals')
            ->where('userID', '=', $userID)
            ->whereDate('date', '>=', Carbon::now()->subDays(7))
            ->whereDate('date', '<=', Carbon::now())
            ->paginate(5);
    }

    public function getLastMonthMeals ($userID): Collection
    {
        return DB::table('meals')
            ->where('userID', '=', $userID)
            ->whereDate('date', '>=', Carbon::now()->subMonth(1))
            ->whereDate('date', '<=', Carbon::now())
            ->get();
    }

    public function filterMealsByDateTimeRange( $userID, $dateFrom, $dateTo, $timeFrom, $timeTo ): Collection
    {
        $query = DB::table('meals')->where('userID', '=', $userID);

        if( isset($dateFrom, $dateTo) && strlen($dateFrom) > 0 && strlen($dateTo) > 0 ) {
            $query->whereBetween('date', [$dateFrom, $dateTo]);
        }
        if( isset($timeFrom, $timeTo) && strlen($timeFrom) > 0 && strlen($timeTo) > 0 ) {
            $query->whereBetween('time', [$timeFrom, $timeTo]);
        }

        return $query->get();
    }

    public function getSumOfCaloriesByDateRange($userID,$dateFrom, $dateTo): Collection
    {
        $query = DB::table('meals')->where('userID', '=', $userID)->orderBy('date');
        if( isset($dateFrom, $dateTo) && strlen($dateFrom) > 0 && strlen($dateTo) > 0 ) {
            $query->whereBetween('date', [$dateFrom, $dateTo]);
        }
        return $query
            ->selectRaw('sum(cal_num) as cal_num, date')
            ->groupBy('date')
            ->get()
            ->map(function($item){
                return [
                    'date' => date('m/d/Y', strtotime($item->date)),
                    'total' => $item->cal_num
                ];
            });
    }

    public function deleteUserMeals($userID): int
    {
        return DB::table('meals')
            ->where('userID' , '=', $userID)->delete();
    }

    public function apiGetUserMeals($userID): Collection
    {
        return  DB::table('meals')
            ->select('*')
            ->where('userID','=', $userID)
            ->get();
    }

    public function apiDeleteUserMeals($mealID): int
    {
        return DB::table('meals')
            ->where('id', '=', $mealID)
            ->delete();
    }

    public function apiGetMealsForUser($userID): Collection
    {
        return  DB::table('meals')
            ->select('*')
            ->where('userID','=', $userID)
            ->get();
    }

}
