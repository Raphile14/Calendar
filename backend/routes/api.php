<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarsController;
use App\Models\Calendars;

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

// Routes for the calendars API
Route::get('/calendars', [CalendarsController::class, 'get']);
Route::post('/calendars', [CalendarsController::class, 'post']);
Route::put('/calendars/{calendar}', [CalendarsController::class, 'put']);
Route::delete('/calendars/{calendar}', [CalendarsController::class, 'delete']);
