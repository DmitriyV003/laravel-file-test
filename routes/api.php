<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
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
Route::get('/', function () {
    return 'Ok';
});

Route::post('/registration', [RegistrationController::class, 'registration']);
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::resource('event', EventController::class)->only(['index', 'store', 'destroy', 'show']);
    Route::post('event/{event}/subscribe', [EventController::class, 'subscribe']);
    Route::post('event/{event}/unsubscribe', [EventController::class, 'unsubscribe']);
    Route::get('my-events', [EventController::class, 'myEvents']);

    Route::get('me', [AuthController::class, 'me']);
});
