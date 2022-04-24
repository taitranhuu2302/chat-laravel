<?php

namespace App\Repositories\FriendRequest;

use App\Repositories\RepositoryInterface;

interface FriendRequestInterface extends RepositoryInterface
{
    public function findFriendRequestByUserId($id);
}
