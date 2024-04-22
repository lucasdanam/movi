<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'create');
    Route::post('/login', 'login');
    Route::get('/transportistas', 'getTransportistas');
    //Route::post('/transportistas/elegir', 'elegirTransportista')->middleware('auth:sanctum');
});