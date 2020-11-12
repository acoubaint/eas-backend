<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;

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

Route::post('registration', [UserController::class, 'store']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::delete('logout', [UserController::class, 'logout']);
    Route::get('profile', [UserController::class, 'show']);
    Route::post('events', [EventController::class, 'store']);
    Route::get('events', [EventController::class, 'index']);
    Route::post('events/{id}/attend', [EventController::class, 'attend']);
});
