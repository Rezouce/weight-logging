<?php

use App\Http\Controllers\IndexWeightController;
use App\Http\Controllers\SaveWeightController;
use App\Models\Weight;
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

Route::get('/', IndexWeightController::class)->name('index-weight');
Route::post('/', SaveWeightController::class)->name('save-weight');
