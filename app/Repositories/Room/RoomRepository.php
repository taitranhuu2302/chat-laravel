<?php

namespace App\Repositories\Room;

use App\Enums\RoomType;
use App\Models\Room;
use App\Repositories\BaseRepository;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Room::class;
    }


    public function findById($id)
    {
        return $this->model->with('users')->with('messages')->findOrFail($id);
    }

    public function createRoomPrivate($userOne, $userTwo): Room
    {
        $room = new Room();

        $room->room_type = RoomType::PRIVATE_ROOM;
        $room->save();

        $room->users()->attach($userOne);
        $room->users()->attach($userTwo);

        return $room;
    }

    public function addUserToRoom($roomId, $userId)
    {
        $room = $this->findById($roomId);
        if ($room->users()->where('user_id', $userId)->exists()) {
            return null;
        }

        if ($room->room_type == RoomType::PRIVATE_ROOM) {
            if ($room->users()->count() == 2) {
                return null;
            }
        }
        $room->users()->attach($userId);
        return $room;
    }



    public function findAllRoomByUserId($id)
    {
        return $this->model
            ->with('users')
            ->with('messages')
            ->orderBy('updated_at', 'desc')
            ->where('is_active', true)
            ->whereHas('users', function ($query) use ($id) {
                $query->where('user_id', $id);
            })->get();
    }

    public function checkRoomPrivateAlreadyExists($userOneId, $userTwoId)
    {
        return $this->model->whereHas('users', function ($query) use ($userOneId) {
            $query->where('room_type', RoomType::PRIVATE_ROOM)->where('user_id', $userOneId);
        })->whereHas('users', function ($query) use ($userTwoId) {
            $query->where('room_type', RoomType::PRIVATE_ROOM)->where('user_id', $userTwoId);
        })->first();
    }

    public function isRoomExists($userId, $roomId): bool
    {
        $room = $this->model->where('id', $roomId)->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->first();

        if ($room) {
            return true;
        }

        return false;
    }

    public function removeUserFromRoom($roomId, $userId)
    {
        $room = $this->model->where('id', $roomId)->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->first();
        $room->users()->detach($userId);
        return $room;
    }

    public function isOwnerFromRoom($roomId, $userId): bool
    {
        $room = $this->model->where('id', $roomId)->where('room_type', RoomType::GROUP_ROOM)->where('owner_id', $userId)->first();

        if ($room) {
            return true;
        }

        return false;
    }

}
