<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Http\Requests\PostMessageRequest;
use App\Models\Image;
use App\Repositories\Message\MessageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            $images = $request->input('images');


            $user = Auth::user();

            $message = $this->messageRepository->create([
                'text' => $text ?? '',
                'room_id' => $roomId,
                'user_id' => $user->id,
            ]);

            $messageImages = [];

            if ($images) {
                foreach ($images as $image) {
                    $check = isBase64($image);
                    if (!$check) {
                        return response()->json(['message' => 'Image is not valid'], 400);
                    }

                    $file = handleImageBase64($image);

                    $messageImages[] = new Image([
                        'source' => $file['path_file'],
                        'message_id' => $message->id,
                    ]);
                }
            }

            $message->images()->saveMany($messageImages);
            $message->load('images');

            event(new ChatEvent($message, $roomId, $user));

            return response()->json(['message' => 'success', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMessage(Request $request, $roomId)
    {
        try {
            $messages = $this->messageRepository->getMessageByRoom($roomId);

            return response()->json(['messages' => $messages], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
