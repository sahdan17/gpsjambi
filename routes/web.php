<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/navbar', function () {
    return view('navbar');
});

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/history', function () {
    return view('history');
});

Route::get('/route', function () {
    return view('route');
});

Route::post('/getLatestRecord', [RecordController::class,'getLatestRecord']);
Route::post('/getRecordByDevice', [RecordController::class,'getRecordByDevice']);

// Route::get('/', [RecordController::class,'view']);
