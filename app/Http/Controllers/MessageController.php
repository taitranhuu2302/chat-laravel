<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Http\Requests\PostMessageRequest;
use App\Repositories\Message\MessageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepo)
    {
        $this->messageRepository = $messageRepo;
    }

    public function sendMessage(PostMessageRequest $request)
    {
        try {
            $text = $request->input('text');
            $roomId = $request->input('room_id');
            $user = Auth::user();

            $message = $this->messageRepository->create([
                'text' => $text,
                'room_id' => $roomId,
                'user_id' => $user->id,
            ]);

            event(new ChatEvent($message, $roomId, $user));

            return response()->json(['message' => 'success', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
