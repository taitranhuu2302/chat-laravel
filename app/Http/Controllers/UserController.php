<?php

namespace App\Http\Controllers;

use App\Events\AddFriendEvent;
use App\Http\Requests\AddFriendRequest;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function addFriendRequest(AddFriendRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $userId = $request->userId;
            $userCurrent = $this->userRepository->findById($userId);
            $userTo = $this->userRepository->findByEmail($request->email);

            if (!$userTo) {
                return response()->json(['message' => 'Failed'], 404);
            }

            FriendRequest::create([
                'user_id' => $userTo->id, // 
                'request_id' => $userCurrent->id
            ]);

            AddFriendEvent::dispatch($userTo->id, $userCurrent);

            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
