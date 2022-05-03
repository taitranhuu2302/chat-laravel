<?php

namespace App\Http\Controllers;

use App\Enums\FriendRequestStatus;
use App\Enums\FriendStatus;
use App\Events\AcceptFriendEvent;
use App\Events\AddFriendEvent;
use App\Http\Requests\AcceptFriendRequest;
use App\Http\Requests\AddFriendRequest;
use App\Http\Requests\BlockFriendRequest;
use App\Http\Requests\EditProfileRequest;
use App\Repositories\Friend\FriendRepositoryInterface;
use App\Repositories\FriendRequest\FriendRequestInterface;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;
    protected FriendRequestInterface $friendRequestRepository;
    protected FriendRepositoryInterface $friendRepository;
    protected ProfileRepositoryInterface $profileRepository;

    public function __construct(
        UserRepositoryInterface    $userRepo,
        FriendRequestInterface     $friendRequestRepo,
        FriendRepositoryInterface  $friendRepo,
        ProfileRepositoryInterface $profileRepo
    )
    {
        $this->userRepository = $userRepo;
        $this->friendRequestRepository = $friendRequestRepo;
        $this->friendRepository = $friendRepo;
        $this->profileRepository = $profileRepo;
    }

    public function index()
    {
        return $this->userRepository->findAll();
    }

    public function editProfile(EditProfileRequest $request)
    {

        try {
            $file = null;
            $checkBase64 = isBase64($request->avatar);

            if ($checkBase64) {
                $file = handleImageBase64($request->avatar);
            }

            $avatar = $file !== null ? $file['path_file'] : Auth::user()->avatar;

            $this->userRepository->findById(Auth::user()->id)->update([
                'full_name' => $request->full_name,
                'avatar' => $avatar,
            ]);

            $this->profileRepository->updateByUserId(Auth::id(), [
                'phone' => $request->phone,
                'address' => $request->address,
                'country' => $request->country,
                'about_myself' => trim($request->about_myself),
            ]);

            return response()->json(['message' => 'success', 'status' => 200], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function addFriendRequest(AddFriendRequest $request): JsonResponse
    {
        try {
            $userId = Auth::id();
            $userCurrent = $this->userRepository->findById($userId);
            $userTo = $this->userRepository->findByEmail($request->email);
            $description = $request->description ? $request->description : 'Xin chào ' . $userCurrent->full_name;

            if (!$userTo) {
                return response()->json(['message' => 'Failed'], 404);
            }

            $checkFriendExist = $this->friendRepository->findAllFriendsByUserId($userId, $userTo->id);
            $checkFriendRequest = $this->friendRequestRepository->findFriendRequest($userId, $userTo->id);

            if (count($checkFriendRequest) > 0) {
                return response()->json(['message' => 'Bạn đã gửi lời mời kết bạn'], 400);
            }

            if (count($checkFriendExist) > 0) {
                return response()->json(['message' => "Hai bạn đã trở thành bạn bè", 'status' => 400], 400);
            }

            $this->friendRequestRepository->create([
                'user_id' => $userTo->id, //
                'request_id' => $userCurrent->id,
                'description' => $description,
            ]);

            event(new AddFriendEvent($userTo->id, $userCurrent, $description));

            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function acceptFriendRequest(AcceptFriendRequest $request): JsonResponse
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

    public function blockFriendRequest(BlockFriendRequest $request): JsonResponse
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

    public function blockFriend(BlockFriendRequest $request): JsonResponse
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
