<?php

namespace App\Repositories\Friend;

use App\Repositories\RepositoryInterface;

interface FriendRepositoryInterface extends RepositoryInterface
{
    public function findAllFriendsByUserId($id);

    public function findFriend($userId, $friendId);

    public function changeStatusFriend($userId, $friendId, $status);

    public function acceptFriend($userOne, $userTwo);
}
