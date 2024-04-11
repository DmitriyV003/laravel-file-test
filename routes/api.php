<?php

use App\Http\Controllers\AngleController;
use App\Http\Controllers\FieldTypeController;
use App\Http\Controllers\FormApplicationController;
use App\Http\Controllers\FormTypeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\StyleController;
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
