<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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
     * @var mixed
     */

    public function storeMeal($title, $cal_num, $date, $time, $userID)
    {
        return DB::table('meals')->insertGetId([
            'title' => $title,
            'cal_num' => $cal_num,
            'date' => $date,
            'time' => $time,
            'userID' => $userID,
        ]);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getMealsForUser($userID): \Illuminate\Support\Collection
    {
       return ( DB::table('meals')
           ->select('*')
           ->where('userID','=', $userID)
           ->get());

    }

    public function getLatestMeal($userID): \Illuminate\Support\Collection
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

    public function editMeal ($id, $title, $cal_num, $date, $time, $userID): int
    {
        return DB::table('meals')
            ->where('id', '=', $id)
            ->update([
            'title' => $title,
            'cal_num' => $cal_num,
            'date' => $date,
            'time' => $time,
            'userID' => $userID,
        ]);

    }

    public function getLastWeekMeals (): \Illuminate\Support\Collection
    {
        return DB::table('meals')
            ->whereDate('date', '>=', Carbon::today()->subDays(7))
            ->get();
    }
}
