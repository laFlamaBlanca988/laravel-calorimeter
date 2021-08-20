<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealsController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WelcomeController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\YamlFrontMatter\YamlFrontMatter;


Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('guest');

Route::get('welcome', [WelcomeController::class, 'index'])->middleware('auth');

Route::get('register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');
Route::post('logout', [SessionsController::class, 'destroy'])->name('logout')->middleware('auth');

Route::get('meals', [MealsController::class, 'index'])->middleware('auth');
Route::post('meals', [MealsController::class, 'store'])->middleware('auth');

//Route::delete('welcome', [MealsController::class, 'destroy'])->middleware('auth');


