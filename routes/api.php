<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::get('welcome', 'index')->name('welcome');
    Route::post('registerUser',  'register')->name('register');
    Route::post('login', 'login')->name('apilogin');
    Route::get('profile', 'userProfile')->name('profile')->middleware('auth:sanctum');
    Route::get('logout', 'userLogout')->name('apilogout')->middleware('auth:sanctum');
});
