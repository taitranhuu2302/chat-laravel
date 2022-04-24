<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AcceptFriendEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $userId;
    public User $friend;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId, User $friend)
    {
        $this->userId = $userId;
        $this->friend = $friend;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('accept-friend.' . $this->userId);
    }
}
