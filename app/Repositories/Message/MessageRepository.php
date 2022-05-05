<?php

namespace App\Repositories\Message;

use App\Models\Message;
use App\Repositories\BaseRepository;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    public function getModel(): string
    {
        return Message::class;
    }

    public function getMessageByRoom($roomId)
    {
        return $this->model->where('room_id', $roomId)
            ->with('user')
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }
}
