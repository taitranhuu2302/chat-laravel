<?php

namespace App\Http\Controllers;

use App\Enums\FriendRequestStatus;
use App\Enums\FriendStatus;
use App\Events\AcceptFriendEvent;
use App\Events\AddFriendEvent;
use App\Http\Requests\AcceptFriendRequest;
use App\Http\Requests\AddFriendRequest;
use App\Http\Requests\BlockFriendRequest;
use App\Repositories\Friend\FriendRepositoryInterface;
use App\Repositories\FriendRequest\FriendRequestInterface;
use App\Repositories\User\UserRepositoryInterface;
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
            $userId = Auth::id();
            $userCurrent = $this->userRepository->findById($userId);
            $userTo = $this->userRepository->findByEmail($request->email);

            if (!$userTo) {
                return response()->json(['message' => 'Failed'], 404);
            }

            $checkExist = $this->friendRepository->findAllFriendsByUserId($userId, $userTo->id);
            Log::info($checkExist);
            if (count($checkExist) > 0) {
                return response()->json(['message' => 'Bạn không thể kết bạn lại', 'status' => 400], 400);
            }

            $this->friendRequestRepository->create([
                'user_id' => $userTo->id, //
                'request_id' => $userCurrent->id
            ]);

            event(new AddFriendEvent($userTo->id, $userCurrent));

            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function acceptFriendRequest(AcceptFriendRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $userId = Auth::id();
            $userAcceptId = $request->user_accept_id;

            $userCurrent = $this->userRepository->findById($userId);
            $userTo = $this->userRepository->findById($userAcceptId);

            $this->friendRequestRepository->changeStatusFriendRequest($userId, $userAcceptId, FriendRequestStatus::ACCEPTED);

            $this->friendRepository->create([
                'user_id' => $userId,
                'friend_id' => $userAcceptId
            ]);

            $this->friendRepository->create([
                'user_id' => $userAcceptId,
                'friend_id' => $userId
            ]);

            event(new AcceptFriendEvent($userTo->id, $userCurrent));
            event(new AcceptFriendEvent($userCurrent->id, $userTo));

            return response()->json(['message' => 'Success', 'status' => 200], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function blockFriendRequest(BlockFriendRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $userId = Auth::id();
            $userBlockId = $request->user_block_id;

            $this->friendRequestRepository->changeStatusFriendRequest($userId, $userBlockId, FriendRequestStatus::REJECTED);

            return response()->json(['message' => 'Success', 'status' => 200], 200);

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function blockFriend(BlockFriendRequest $request)
    {
        try {

            $userId = Auth::id();
            $userBlockId = $request->user_block_id;

            $this->friendRepository->changeStatusFriend($userId, $userBlockId, FriendStatus::BLOCKED);
            $this->friendRepository->changeStatusFriend($userBlockId, $userId, FriendStatus::BLOCKED);

            return response()->json(['message' => 'Success', 'status' => 200], 200);

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
