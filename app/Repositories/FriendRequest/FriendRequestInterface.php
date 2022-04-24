<?php

namespace App\Repositories\FriendRequest;

use App\Repositories\RepositoryInterface;

interface FriendRequestInterface extends RepositoryInterface
{
    public function findAllFriendRequestByUserId($id);

    public function findFriendRequest($userId, $requestId);

    public function changeStatusFriendRequest($userId, $requestId, $status);
}
