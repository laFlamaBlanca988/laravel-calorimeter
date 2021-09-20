<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealsController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome')->middleware('guest');

Route::get('home', [HomeController::class, 'index'])->middleware('auth');
Route::get('home/fetch_data', [HomeController::class, 'fetch_data']);

Route::get('admin', [AdminController::class, 'index'])->middleware('isAdmin');
Route::get('admin/meals', [AdminController::class, 'fetchAllMeals']);

Route::get('register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'index'])->name('login');
Route::post('login', [SessionsController::class, 'store']);
Route::post('logout', [SessionsController::class, 'destroy'])->name('logout')->middleware('auth');

Route::get('meals', [MealsController::class, 'index'])->middleware('auth');
Route::post('meals', [MealsController::class, 'store'])->middleware('auth');

Route::post('/meal/delete', [MealsController::class, 'destroy']);

Route::post('/meal/edit', [MealsController::class, 'edit']);

Route::get('/meal/lastWeek', [MealsController::class, 'getLastWeekData']);
Route::get('/meal/lastMonth', [MealsController::class, 'getLastMonthData']);
Route::post('/meal/dateTimeFilter', [MealsController::class, 'getMealsByDateAndTime']);

Route::get('userEdit', [UserController::class, 'index'])->middleware('auth');
Route::post('userEdit', [UserController::class, 'editUserControl'])->middleware('auth');

Route::post('adminUserEdit', [AdminController::class, 'editUser'])->middleware('auth');
Route::post('adminUserMeals', [AdminController::class, 'displayUserMeals'])->middleware('auth');
Route::post('adminUserAccess', [AdminController::class, 'updateUserAccess'])->middleware('auth');
Route::post('adminUserDelete', [AdminController::class, 'adminUserDelete'])->middleware('auth');
Route::post('adminMealsDelete', [AdminController::class, 'adminMealDelete'])->middleware('auth');

