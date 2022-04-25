<?php

namespace App\Repositories\Friend;

use App\Enums\FriendStatus;
use App\Models\Friend;
use App\Repositories\BaseRepository;

class FriendRepository extends BaseRepository implements FriendRepositoryInterface
{

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Friend::class;
    }

    public function findAllFriendsByUserId($id)
    {
        return $this->model->where('user_id', $id)
            ->where('status', '=', FriendStatus::FRIEND)
            ->with('user')->get()->sortByDesc('updated_at');
    }

    public function changeStatusFriend($userId, $friendId, $status)
    {
        return $this->model->where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->update(['status' => $status]);
    }

    public function findFriend($userId, $friendId)
    {
        return $this->model->where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->first();
    }
}
