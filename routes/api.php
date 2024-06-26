<?php
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can auth API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('user/{id}/meals', [ApiController::class, 'readMeals'])->middleware('api');
Route::post('/meals/store', [ApiController::class, 'storeMeal'])->middleware('api');
Route::post('/meals/{id}/delete', [ApiController::class, 'deleteMeal'])->middleware('api');
Route::post('/meals/{id}/edit', [ApiController::class, 'editMeal'])->middleware('api');
