<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TaskController;
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
    Route::get('/login', [AuthController::class, 'viewLogin'])->name('login')->middleware('checkLogin');
    Route::get('/create-new-password', [AuthController::class, 'viewCreateNewPassword'])->middleware('auth');
    Route::get('/change-password', [AuthController::class, 'viewChangePassword'])->middleware('auth');
    Route::get('/register', [AuthController::class, 'viewRegister'])->middleware('checkLogin');

    // Action
    Route::post('/create-new-password', [AuthController::class, 'postCreateNewPassword']);
    Route::post('/change-password', [AuthController::class, 'postChangePassword']);
    Route::post('/login', [AuthController::class, 'postLogin']);
    Route::post('/register', [AuthController::class, 'postRegister']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('noCache');

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
        Route::post('/create-room-group', [RoomController::class, 'createRoomGroup']);
        Route::put('/edit-room', [RoomController::class, 'editGroupRoom']);
        Route::post('/leave-group', [RoomController::class, 'leaveGroup']);
        Route::post('/add-member-group', [RoomController::class, 'addMemberGroup']);
    });

    Route::prefix('message')->group(function() {
        Route::post('/send-message', [MessageController::class, 'sendMessage']);
        Route::get('/get-message/{roomId}', [MessageController::class, 'getMessage']);
    });

    Route::prefix('task')->group(function() {
        Route::post('/', [TaskController::class, 'createTask']);
        Route::delete('/{id}', [TaskController::class, 'deleteTask']);
    });
});
