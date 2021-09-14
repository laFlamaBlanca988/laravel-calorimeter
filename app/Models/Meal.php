<?php

namespace App\Models;

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
     * @return Collection
     */

    public function getAllMeals(): Collection
    {
        return DB::table('meals')->get();

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

    public function getMealsForUser($userID): Collection
    {
       return ( DB::table('meals')
           ->select('*')
           ->where('userID','=', $userID)
           ->get());
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
          ->where('userID', '=', Auth::user()->id)
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

    public function getLastWeekMeals ($userID): Collection
    {
        return DB::table('meals')
            ->where('userID', '=', $userID)
            ->whereDate('date', '>=', Carbon::now()->subDays(7))
            ->whereDate('date', '<=', Carbon::now())
            ->get();
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

    public function getSumOfCalories($userID) {
      return  DB::table("meals")
          ->where('userID', '=', $userID)
          ->get()
          ->sum("cal_num");
    }

    public function deleteUserMeals($userID): int
    {
        return DB::table('meals')
            ->where('userID' , '=', $userID)->delete();
    }

}
