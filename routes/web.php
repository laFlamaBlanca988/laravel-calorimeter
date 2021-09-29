<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChartDataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MealsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login')->middleware('auth');
Route::post('logout', [LoginController::class, 'loggedOut'])->name('logout')->middleware('auth');

Auth::routes();
Route::get('home', [HomeController::class, 'index'])->middleware('auth');
Route::get('home/fetch_data', [HomeController::class, 'fetch_data'])->middleware('auth');

Route::get('meals', [MealsController::class, 'index'])->middleware('auth');
Route::post('meals', [MealsController::class, 'store'])->middleware('auth');
Route::post('/meal/edit', [MealsController::class, 'edit'])->middleware('auth');
Route::post('/meal/delete', [MealsController::class, 'destroy'])->middleware('auth');
Route::get('/meal/lastWeek', [MealsController::class, 'getLastWeekData'])->middleware('auth');
Route::get('/meal/lastMonth', [MealsController::class, 'getLastMonthData'])->middleware('auth');
Route::post('/meal/dateTimeFilter', [MealsController::class, 'getMealsByDateAndTime'])->middleware('auth');

Route::get('userEdit', [UserController::class, 'index'])->middleware('auth');
Route::post('userEdit', [UserController::class, 'editUserControl'])->middleware('auth');

Route::get('admin', [AdminController::class, 'index'])->middleware('admin');
Route::get('admin/meals', [AdminController::class, 'fetchAllMeals'])->middleware('admin');
Route::post('adminUserAccess', [AdminController::class, 'updateUserAccess'])->middleware('admin');
Route::post('adminMealsDelete', [AdminController::class, 'adminMealDelete'])->middleware('admin');

Route::post('adminUserEdit', [AdminController::class, 'editUser'])->middleware('auth');
Route::post('adminUserDelete', [AdminController::class, 'adminUserDelete'])->middleware('auth');

Route::get('manager', [ManagerController::class, 'index'])->middleware('manager');
Route::post('userSearch', [AdminController::class, 'userSearch']);
Route::get('getMealsChartData', [ChartDataController::class, 'getCaloriesConsumptionData']);
