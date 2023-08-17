<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/datos/{feedName}', [RegisterController::class, 'obtenerDatosFeed']);
    Route::get('/ultimoDato/{feedName}', [RegisterController::class, 'obtenerUltimoDato']);
    Route::get('/obtenerTodo', [RegisterController::class, 'obtenerTodo']);
});
