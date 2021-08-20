<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function storeMeal($title, $cal_num, $date, $time, $userID)
    {
        DB::table('meals')->insert([
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
      return DB::table('meals')->where('id', '=', $mealID)->delete();
    }
}
