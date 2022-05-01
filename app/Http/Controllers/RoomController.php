<?php

namespace App\Http\Controllers;

use App\Enums\RoomType;
use App\Events\CreateRoomEvent;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\CreateRoomPrivateRequest;
use App\Models\FriendRequest;
use App\Models\Room;
use App\Repositories\Friend\FriendRepositoryInterface;
use App\Repositories\FriendRequest\FriendRequestInterface;
use App\Repositories\FriendRequest\FriendRequestRepository;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    protected RoomRepositoryInterface $roomRepository;
    protected FriendRequestInterface $friendRequestRepository;

    public function __construct(RoomRepositoryInterface $roomRepo, FriendRequestInterface $friendRequestRepo)
    {
        $this->roomRepository = $roomRepo;
        $this->friendRequestRepository = $friendRequestRepo;
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

        return view('pages.room')->with('roomById', $room)->with('rooms', $roomByUserId)->with('friendRequests', $friendRequests);
    }

    public function createRoomGroup(CreateGroupRequest $request)
    {
        try {
            $room = $this->roomRepository->create([
                'name' => $request->name,
                'description' => $request->description,
                'type' => RoomType::GROUP_ROOM,
            ]);

            $this->roomRepository->addUserToRoom($room->id, Auth::id());
            foreach ($request->members as $user) {
                $this->roomRepository->addUserToRoom($room->id, $user);
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
}
