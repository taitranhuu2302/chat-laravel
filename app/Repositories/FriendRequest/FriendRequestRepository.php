<?php

namespace App\Repositories\FriendRequest;

use App\Models\FriendRequest;
use App\Repositories\BaseRepository;
use App\Repositories\RepositoryInterface;

class FriendRequestRepository extends BaseRepository implements FriendRequestInterface
{

    public function getModel(): string
    {
        return FriendRequest::class;
    }

    public function findFriendRequestByUserId($id)
    {
        return FriendRequest::where('user_id', $id)
            ->where('status', '=', 'PENDING')
            ->with('user')->get()->sortByDesc('id');
    }
}
