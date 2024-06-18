<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/driver-information/{reservation_code}', [ReservationController::class, 'driverInformation']);
Route::put('/pickup-schedule/{reservation_code}', [ReservationController::class, 'changePickupSchedule']);
Route::put('/reschedule/{reservation_code}', [ReservationController::class, 'reschedule']);

Route::get('/test-mailing/{reservation_code}', [ReservationController::class, 'mailingTester']);
