<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RouteZoneController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/store', [RecordController::class,'store']);
Route::post('/getRecordByDevice', [RecordController::class,'getRecordByDevice']);
Route::post('/getLatestRecord', [RecordController::class,'getLatestRecord']);
Route::post('/areaCheck', [RecordController::class,'areaCheck']);

Route::post('/ppssglRoute', [RouteZoneController::class,'ppssglRoute']);
Route::post('/formatCoordinates', [RouteZoneController::class,'formatCoordinates']);

Route::post('/storeVehicle', [VehicleController::class,'storeVehicle']);