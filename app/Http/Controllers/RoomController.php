<?php

namespace App\Http\Controllers;

use App\Enums\RoomType;
use App\Http\Requests\CreateRoomPrivateRequest;
use App\Models\Room;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    protected RoomRepositoryInterface $roomRepository;

    public function __construct(RoomRepositoryInterface $roomRepo)
    {
        $this->roomRepository = $roomRepo;
    }

    public function index(): JsonResponse
    {
        return response()->json(['message' => 'success', 'status' => 200, 'data' => $this->roomRepository->findAll()]);
    }

    public function showRoomById($id)
    {
        $room = $this->roomRepository->findById($id);

        $roomByUserId = $this->roomRepository->findAllRoomByUserId(Auth::id());

        return view('pages.room')->with('roomById', $room)->with('rooms', $roomByUserId);
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

            $room = $this->roomRepository->createRoomPrivate($userOneId, $userTwoId);

            return response()->json(['message' => 'success', 'status' => 200, 'data' => $room]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'error', 'status' => 500, 'data' => $e->getMessage()]);
        }
    }
}
