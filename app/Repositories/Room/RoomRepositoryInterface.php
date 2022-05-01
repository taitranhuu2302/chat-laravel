<?php

namespace App\Repositories\Room;

use App\Repositories\RepositoryInterface;

interface RoomRepositoryInterface extends RepositoryInterface
{
    public function createRoomPrivate($userOne, $userTwo);

    public function findAllRoomByUserId($id);

    public function checkRoomPrivateAlreadyExists($userOneId, $userTwoId);

    public function isRoomExists($userId, $roomId);

    public function addUserToRoom($roomId, $userId);
}
