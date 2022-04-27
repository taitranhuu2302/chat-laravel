<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\Room;
use App\Models\User;
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
    Route::get('/logout', [AuthController::class, 'logout']);


    // Login Social Google
    Route::get('/google', [AuthController::class, 'googleRedirect']);
    Route::get('/google/callback', [AuthController::class, 'googleCallback']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/room/{id}', function ($id) {
        return view('pages.room')->with('id', $id);
    });

    Route::prefix('user')->group(function () {

        Route::post('/add-friend-request', [UserController::class, 'addFriendRequest']);
        Route::post('/accept-friend-request', [UserController::class, 'acceptFriendRequest']);
        Route::post('/block-friend-request', [UserController::class, 'blockFriendRequest']);
        Route::post('/block-friend', [UserController::class, 'blockFriend']);
        Route::put('/edit-profile', [UserController::class, 'editProfile']);
        Route::get('/', [UserController::class, 'index']);
    });

    Route::prefix('room')->group(function() {
        Route::get('/', [RoomController::class, 'index']);
//        Route::get('/{id}', [RoomController::class, 'show']);
        Route::post('/create-room-private', [RoomController::class, 'createRoomPrivate']);
        Route::get('/{id}', [RoomController::class, 'showRoomById']);
    });

    Route::prefix('message')->group(function() {
        Route::post('/send-message', [MessageController::class, 'sendMessage']);
//        Route::get('/get-message', [MessageController::class, 'getMessage']);
    });
});
