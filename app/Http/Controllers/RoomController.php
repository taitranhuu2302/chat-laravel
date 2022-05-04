<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Enums\RoomType;
use App\Events\ChatEvent;
use App\Events\CreateRoomEvent;
use App\Events\UpdateRoomEvent;
use App\Http\Requests\AddMemberToGroupRequest;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\CreateRoomPrivateRequest;
use App\Http\Requests\LeaveGroupRequest;
use App\Models\User;
use App\Repositories\FriendRequest\FriendRequestInterface;
use App\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    protected RoomRepositoryInterface $roomRepository;
    protected FriendRequestInterface $friendRequestRepository;
    protected MessageRepositoryInterface $messageRepository;
    protected UserRepositoryInterface $userRepository;

    public function __construct(RoomRepositoryInterface $roomRepo, FriendRequestInterface $friendRequestRepo, MessageRepositoryInterface $messageRepo, UserRepositoryInterface $userRepo)
    {
        $this->roomRepository = $roomRepo;
        $this->friendRequestRepository = $friendRequestRepo;
        $this->messageRepository = $messageRepo;
        $this->userRepository = $userRepo;
    }

    public function index(): JsonResponse
    {
        return response()->json(['message' => 'success', 'status' => 200, 'data' => $this->roomRepository->findAll()]);
    }

    public function showRoomById($id)
    {
        $checkRoom = $this->roomRepository->isRoomExists(Auth::id(), $id);

        if (!$checkRoom) {
            return redirect('/');
        }

        $room = $this->roomRepository->findById($id);

        $roomByUserId = $this->roomRepository->findAllRoomByUserId(Auth::id());
        $friendRequests = $this->friendRequestRepository->findAllFriendRequestByUserId(Auth::id());
        $messages = $this->messageRepository->getMessageByRoom($id);

        return view('pages.room')->with('roomById', $room)
            ->with('messages', $messages)
            ->with('rooms', $roomByUserId)
            ->with('friendRequests', $friendRequests);
    }

    public function editGroupRoom(Request $request)
    {
        try {
            $roomName = $request->input('roomName');
            $roomAvatar = $request->input('roomAvatar');
            $roomId = $request->input('roomId');

            $file = null;

            $room = $this->roomRepository->findById($roomId);

            $checkBase64 = $roomAvatar ? isBase64($roomAvatar) : null;
            if ($checkBase64) {
                $file = handleImageBase64($roomAvatar);
            }

            $image = $file ? $file['path_file'] : $room->image;

            $roomUpdate = $this->roomRepository->update($roomId, [
                'name' => $roomName ?? $room->name,
                'image' => $image
            ]);

            $text = $roomName ? Auth::user()->full_name . ' đã thay đổi tên nhóm thành ' . $roomName : Auth::user()->full_name . ' đã thay đổi ảnh nhóm';

            $message = $this->messageRepository->create([
                'text' => $text,
                'room_id' => $roomId,
                'message_type' => MessageType::NOTIFICATION
            ]);

            event(new ChatEvent($message, $roomId, null));
            event(new UpdateRoomEvent($roomUpdate));

            return response()->json(['message' => 'success', 'status' => 200]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage(), 'status' => 500], 500);
        }
    }

    public function createRoomGroup(CreateGroupRequest $request)
    {
        try {
            $room = $this->roomRepository->create([
                'name' => $request->name,
                'description' => $request->description,
                'room_type' => RoomType::GROUP_ROOM,
                'owner_id' => Auth::id(),
            ]);

            $this->roomRepository->addUserToRoom($room->id, Auth::id());

            foreach ($request->members as $userId) {
                $this->roomRepository->addUserToRoom($room->id, $userId);
                event(new CreateRoomEvent($userId, $room));
            }

            return response()->json(['message' => 'success', 'status' => 200, 'data' => $room]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage(), 'status' => 500], 500);
        }
    }

    public function createRoomPrivate(CreateRoomPrivateRequest $request)
    {
        try {

            $userOneId = Auth::id();
            $userTwoId = $request->user_id;

            $checkRoom = $this->roomRepository->checkRoomPrivateAlreadyExists($userOneId, $userTwoId);

            if ($checkRoom) {
                return response()->json(['message' => 'Room already exists', 'status' => 409, 'data' => $checkRoom], 409);
            }

            $newRoom = $this->roomRepository->createRoomPrivate($userOneId, $userTwoId);

            $room = $this->roomRepository->findById($newRoom->id);

            event(new CreateRoomEvent($userTwoId, $room));

            return response()->json(['message' => 'success', 'status' => 200, 'data' => $room]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'error', 'status' => 500, 'data' => $e->getMessage()]);
        }
    }

    public function addMemberGroup(AddMemberToGroupRequest $request)
    {
        try {
            $email = $request->input('email');
            $roomId = $request->input('roomId');

            $user = $this->userRepository->findByEmail($email);

            if (!$user) {
                return response()->json(['message' => 'Người dùng không tồn tại', 'status' => 404], 404);
            }

            $userExistsFromRoom = $this->roomRepository->isRoomExists($user->id, $roomId);


            if ($userExistsFromRoom) {
                return response()->json(['message' => 'Người dùng đã tồn tại trong phòng', 'status' => 409], 409);
            }

            $this->roomRepository->addUserToRoom($roomId, $user->id);

            $message = $this->messageRepository->create([
               'room_id' => $roomId,
               'message_type' => MessageType::NOTIFICATION,
               'text' => Auth::user()->full_name . ' đã thêm '. $user->full_name .' vào phòng',
            ]);

            event(new CreateRoomEvent($user->id, $this->roomRepository->findById($roomId)));

            event(new ChatEvent($message, $roomId, null));

            return response()->json(['message' => 'success', 'status' => 200]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage(), 'status' => 500], 500);
        }
    }

    public function leaveGroup(LeaveGroupRequest $request)
    {
        try {
            $roomId = $request->input('roomId');
            $memberId = $request->input('memberId');
            $userId = Auth::id();

            $checkUserInRoom = $this->roomRepository->isRoomExists($userId, $roomId);

            if (!$checkUserInRoom) {
                return response()->json(['message' => 'User not in room', 'status' => 404], 404);
            }

            if ($memberId) {
                $isOwner = $this->roomRepository->isOwnerFromRoom($roomId, $userId);
                $member = User::where('id', $memberId)->first();

                if (!$isOwner) {
                    return response()->json(['message' => 'User is not owner', 'status' => 403], 403);
                }

                $this->roomRepository->removeUserFromRoom($roomId, $memberId);

                $message = $this->messageRepository->create([
                    'room_id' => $roomId,
                    'message_type' => MessageType::NOTIFICATION,
                    'text' => Auth::user()->full_name . ' đã xoá ' . $member->full_name . ' ra khỏi nhóm',
                ]);

                event(new ChatEvent($message, $roomId, null));

                return response()->json(['message' => 'Remove user success', 'status' => 200], 200);
            }

            $this->roomRepository->removeUserFromRoom($roomId, $userId);

            $message = $this->messageRepository->create([
                'room_id' => $roomId,
                'message_type' => MessageType::NOTIFICATION,
                'text' => Auth::user()->full_name . ' đã rời khỏi nhóm',
            ]);

            event(new ChatEvent($message, $roomId, null));

            return response()->json(['message' => 'success', 'status' => 200]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage(), 'status' => 500], 500);
        }
    }
}
