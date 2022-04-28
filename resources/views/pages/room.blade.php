@extends('layouts.main_layout')

@section('title', 'Room')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/room.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection

@section('content')
    @php
        $roomName = '';
        $roomAvatar = '';

        if ($roomById->room_type === \App\Enums\RoomType::PRIVATE_ROOM) {
            foreach ($roomById->users as $user) {
                if ($user->id !== Auth::id()) {
                    $roomName = $user->full_name;
                    $roomAvatar = $user->avatar;
                }
            }
        }
    @endphp
    <div id="room" class="flex flex-col h-full w-full">
        <div class="room__header flex-shrink flex items-center border-b p-4 justify-between">
            <div class="header__left flex items-center gap-4 ">
                <img class="w-9 h-9 rounded-full" src="{{ $roomAvatar }}" alt="Rounded avatar">
                <div>
                    <p class="text-md font-semibold">{{ $roomName }}</p>
                    <p class="text-sm">Online</p>
                </div>
            </div>
            <div class="header__right flex items-center gap-3">
                <button class="border rounded px-3 pt-1 flex items-center justify-center">
                    <i style="color: #0ABB87" class="text-xl far fa-phone"></i>
                </button>
                <button class="border rounded px-3 pt-1 flex items-center jusitfy-center">
                    <i style="color: #FFB822" class="text-xl far fa-video"></i>
                </button>
                <button class="border rounded px-3 pt-1 flex items-center jusitfy-center">
                    <i class="text-xl fal fa-ellipsis-h-alt"></i>
                </button>
            </div>
        </div>
        <div id="chat-message-list" class="room__content gap-4 flex-grow flex flex-col-reverse px-5 pt-2">
            @foreach($roomById->messages as $message)
                @if($message->user->id !== Auth::id())
                    <div class="room__chat room__chat--left">
                        <div class="room__chat--avatar">
                            <img class="w-10 h-10 rounded-full" src="{{ $message->user->avatar }}" alt="Rounded avatar">
                        </div>
                        <div class="room__chat--content">
                            <p class="room__chat--text">
                                {{ $message->text }}
                            </p>
                        </div>
                    </div>
                @elseif ($message->user->id === Auth::id())
                    <div class="room__chat room__chat--right">
                        <div class="room__chat--avatar">
                            <img class="w-10 h-10 rounded-full" src="{{ $message->user->avatar }}" alt="Rounded avatar">
                        </div>
                        <div class="room__chat--content">
                            <p class="room__chat--text">
                                {{ $message->text }}
                            </p>
                        </div>
                    </div>
                @else
                    <div class="chat__message flex justify-center my-2">
                        <p class="chat__message--notify text-gray-500 text-md">
                            {{$message->text}}
                        </p>
                    </div>
                @endif
            @endforeach


        </div>
        <div class="room__footer flex-shrink">
            <form id="form-chat" class="footer__input flex-grow px-5 py-3 flex items-center gap-5">
                <input type="text"
                       id="txt_message"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <div class="footer__buttons flex">
                    <button type="button"
                            class="relative border border-gray-400 bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800">
                        <i class="far text-md fa-image"></i>
                        <label for="input-file" class="cursor-pointer absolute top-0 left-0 right-0 bottom-0"></label>
                        <input type="file" hidden id="input-file">
                    </button>
                    <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm p-3 text-center inline-flex items-center mr-2 ">
                        <i class="far text-md fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('js/navigation.js') }}"></script>
<script>
    const roomId = @json(request()->route('id'));
    const userCurrent = @json(Auth::user());
</script>
<script src="{{ asset('js/chat.js') }}"></script>
