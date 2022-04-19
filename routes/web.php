<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('auth')->group(function () {
    // View
    Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
    Route::get('/change-password', [AuthController::class, 'viewChangePassword']);

    // Action
    Route::post('/change-password', [AuthController::class, 'postChangePassword']);
    Route::post('/login', [AuthController::class, 'postLogin']);


    // Login Social Google
    Route::get('/google', [AuthController::class, 'googleRedirect']);
    Route::get('/google/callback', [AuthController::class, 'googleCallback']);
});

Route::middleware('auth')->group(function() {
    Route::get('/', function() {
        return view('welcome');
    });
});
