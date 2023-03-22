<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('listings', ListingController::class)->except(['edit']);
    Route::resource('users', UserController::class)
        ->only(['show', 'update', 'destroy']);

    Route::post('/auth/logout', [AuthController::class, 'logoutUser']);
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'registerUser'])->name('register');
    Route::post('/login', [AuthController::class, 'loginUser'])->name('login');
});

Route::get('/users', [UserController::class, "index"]);