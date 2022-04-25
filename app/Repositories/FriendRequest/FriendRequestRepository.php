<?php

namespace App\Repositories\FriendRequest;

use App\Enums\FriendRequestStatus;
use App\Models\FriendRequest;
use App\Repositories\BaseRepository;

class FriendRequestRepository extends BaseRepository implements FriendRequestInterface
{

    public function getModel(): string
    {
        return FriendRequest::class;
    }

    public function findAllFriendRequestByUserId($id)
    {
        return $this->model->where('user_id', $id)
            ->where('status', '=', FriendRequestStatus::PENDING)
            ->with('user')->get()->sortByDesc('id');
    }

    public function changeStatusFriendRequest($userId, $requestId, $status)
    {
        return $this->model->where('user_id', $userId)
            ->where('request_id', $requestId)
            ->update(['status' => $status]);
    }

    public function findFriendRequest($userId, $requestId)
    {
        return $this->model->where('user_id', $userId)
            ->where('request_id', $requestId)
            ->first();
    }
}
