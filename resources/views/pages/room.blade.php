@extends('layouts.main_layout')

@section('title', 'Room')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/room.css') }}">
@endsection

@section('content')
    @php
        $roomName = '';
        $roomAvatar = '';

        if ($roomById->room_type === \App\Enums\RoomType::PRIVATE_ROOM) {
            foreach ($roomById->users as $user) {
                if ($user->id !== Auth::id()) {
                    $userProfile = $user;
                    $roomName = $user->full_name;
                    $roomAvatar = $user->avatar;
                }
            }
        } else {
            $roomName = $roomById->name;
            $roomAvatar = $roomById->image ?? '/images/default-avatar.png';
        }
    @endphp
    <div class="flex h-full">
        <div id="room" class="flex flex-col h-full w-full border-r">
            <div class="room__header flex-shrink flex items-center border-b p-4 justify-between">
                <div class="header__left flex items-center gap-4 ">
                    <img class="w-9 h-9 rounded-full image-group-room-preview" src="{{ $roomAvatar }}"
                         alt="Rounded avatar">
                    <div>
                        <p class="text-md room-name font-semibold">{{ $roomName }}</p>
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
                    <button data-dropdown-toggle="dropdown-action-chat"
                            class="border rounded px-3 pt-1 flex items-center jusitfy-center">
                        <i class="text-xl fal fa-ellipsis-h-alt"></i>
                    </button>
                    <div id="dropdown-action-chat"
                         class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                            <li>
                                <button
                                    class="offcanvas__toggle block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Xem hồ sơ
                                </button>
                            </li>
                            <li>
                                <button
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Xoá tin nhắn
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="room__content pt-2 flex flex-col-reverse flex-grow">
                <div id="chat-message-list" class="gap-4 px-5 pt-2 flex flex-col-reverse">
                    @foreach ($messages as $message)
                        @if($message->user === null)
                            <div class="chat__message flex justify-center my-2">
                                <p class="chat__message--notify text-gray-500 text-md">
                                    {{ $message->text }}
                                </p>
                            </div>
                        @elseif ($message->user->id !== Auth::id())
                            <div class="room__chat room__chat--left">
                                <div class="room__chat--avatar">
                                    <img class="w-10 h-10 rounded-full" src="{{ $message->user->avatar }}"
                                         alt="Rounded avatar">
                                </div>
                                <div class="room__chat--content">
                                    @if ($message->text)
                                        <p class="room__chat--text">
                                            {{ $message->text }}
                                        </p>
                                    @endif
                                    @if (count($message->images) > 0)
                                        @foreach ($message->images as $image)
                                            <a href="{{ $image->source }}" data-fancybox="gallery">
                                                <img src="{{ $image->source }}" alt="">
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @elseif ($message->user->id === Auth::id())
                            <div class="room__chat room__chat--right">
                                <div class="room__chat--avatar">
                                    <img class="w-10 h-10 rounded-full" src="{{ $message->user->avatar }}"
                                         alt="Rounded avatar">
                                </div>
                                <div class="room__chat--content">
                                    @if ($message->text)
                                        <p class="room__chat--text">
                                            {{ $message->text }}
                                        </p>
                                    @endif
                                    @if (count($message->images) > 0)
                                        @foreach ($message->images as $image)
                                            <a class="w-full flex justify-end" href="{{ $image->source }}" data-fancybox="gallery">
                                                <img src="{{ $image->source }}" alt="">
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="flex w-full items-center justify-center">
                    @if($messages->nextPageUrl() !== null)
                        <button
                            id="load-more-message"
                            data-url="{{ $messages->nextPageUrl() }}"
                            type="button"
                            class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                            Xem thêm tin nhắn
                        </button>
                    @endif
                </div>
            </div>
            <div class="room__footer flex-shrink px-5">
                <div id="list-file-image" class="room__footer--message-images hidden flex items-center"></div>
                <form id="form-chat" class="footer__input flex-grow py-3 flex items-center gap-5">
                    <input type="text" id="txt_message"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <div class="footer__buttons flex">
                        <button type="button"
                                class="relative border border-gray-400 bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800">
                            <i class="far text-md fa-image"></i>
                            <label for="input-message-image"
                                   class="cursor-pointer absolute top-0 left-0 right-0 bottom-0"></label>
                            <input type="file" hidden id="input-message-image">
                        </button>
                        <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm p-3 text-center inline-flex items-center mr-2 ">
                            <i class="far text-md fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        {{-- Offcanvas Profile --}}
        @if($roomById->room_type === \App\Enums\RoomType::PRIVATE_ROOM)
            <x-sidebar-profile-private :userProfile="$userProfile" :roomName="$roomName" :roomAvatar="$roomAvatar"/>
        @else
            {{--  Sidebar Profile Group   --}}
            <x-sidebar-profile-group :room="$roomById" :roomName="$roomName"
                                     :roomAvatar="$roomAvatar"></x-sidebar-profile-group>
        @endif
    </div>

@endsection

@section('scripts')
    <script>
        const roomId = @json(request()->route('id'));
        const userCurrent = @json(Auth::user());
        console.log(@json($messages));
    </script>

    <script src="{{ asset('js/chat.js') }}"></script>
@endsection
