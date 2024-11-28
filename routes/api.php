<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('welcome', [AuthController::class, 'index'])->name('welcome');
Route::controller(AuthController::class)->group(function () {

    Route::post('registerUser',  'register')->name('register');
    Route::post('login', 'login')->name('apilogin');
    Route::get('profile', 'userProfile')->name('profile')->middleware('auth:sanctum');
    Route::get('logout', 'userLogout')->name('apilogout')->middleware('auth:sanctum');
});

Route::group(['prefix' => 'V1'], function () {
    Route::apiResource('customers', CustomerController::class); // apiResource like Resource but this avoid the create & edit methods for apis
    Route::apiResource('invoices', InvoiceController::class);
});
