<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddFriendRequest;
use App\Models\Friend;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->userRepository = $repository;
    }

    public function index()
    {
        //        return $this->userRepository->findAll();
        return User::with('friends')->get();
    }

    public function addFriendRequest(AddFriendRequest $request)
    {
        try {
            $userId = Auth::user()->id;
            $userTo = $this->userRepository->findByEmail($request->email);

            if (!$userTo) {
                return response()->json(['message' => 'Failed'], 404);
            }

            Friend::create([
                'user_id' => $userId,
                'friend_id' => $userTo->id
            ]);

            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
