<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/api/province/{id}/cities', [HomeController::class, 'getCities']);
Route::post('/store', [HomeController::class,'store'])->name('store');

Route::post('/api/cities', [HomeController::class, 'searchCities']);
