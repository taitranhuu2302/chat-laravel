<?php

namespace App\Http\Controllers;

use App\Events\AcceptFriendEvent;
use App\Events\AddFriendEvent;
use App\Http\Requests\AcceptFriendRequest;
use App\Http\Requests\AddFriendRequest;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use App\Repositories\Friend\FriendRepositoryInterface;
use App\Repositories\FriendRequest\FriendRequestInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;
    protected FriendRequestInterface $friendRequestRepository;
    protected FriendRepositoryInterface $friendRepository;

    public function __construct(
        UserRepositoryInterface   $userRepo,
        FriendRequestInterface    $friendRequestRepo,
        FriendRepositoryInterface $friendRepo
    )
    {
        $this->userRepository = $userRepo;
        $this->friendRequestRepository = $friendRequestRepo;
        $this->friendRepository = $friendRepo;
    }

    public function index()
    {
        return $this->userRepository->findAll();
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

            $this->friendRequestRepository->create([
                'user_id' => $userTo->id, //
                'request_id' => $userCurrent->id
            ]);

            AddFriendEvent::dispatch($userTo->id, $userCurrent);

            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function acceptFriendRequest(AcceptFriendRequest $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->user_id;
        $userAcceptId = $request->user_accept_id;

        $userCurrent = $this->userRepository->findById($userId);
        $userTo = $this->userRepository->findById($userAcceptId);

        $this->friendRequestRepository->changeStatusFriendRequest($userId, $userAcceptId, 'ACCEPTED');

        $this->friendRepository->create([
            'user_id' => $userId,
            'friend_id' => $userAcceptId
        ]);
        $this->friendRepository->create([
            'user_id' => $userAcceptId,
            'friend_id' => $userId
        ]);

        AcceptFriendEvent::dispatch($userCurrent->id, $userTo);
        AcceptFriendEvent::dispatch($userTo->id, $userCurrent);

        return response()->json(['message' => 'Success', 'status' => 200], 200);
    }
}
