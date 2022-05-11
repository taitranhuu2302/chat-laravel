<div class="h-full flex flex-col">
    <div class="chat__header flex-shrink px-8 pt-5 flex justify-between items-center">
        <p class="text-2xl font-semibold">Chats</p>
        <div class="chat__header--button flex gap-3">
            <button class="border-gray-300 border px-3 py-0.5 rounded" type="button"
                    data-modal-toggle="create-group-modal">
                <i class="text-xl far fa-users"></i>
            </button>
    </div>
        </div>

    <div class="chat__search flex-shrink p-8">
        <input type="text" placeholder="Search chats"
               class="text-lg bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>

    <ul id="chat_rooms" class="chat__rooms flex flex-col border-t overflow-y-auto flex-grow">
        @foreach ($rooms as $item)
            @if ($item->room_type === \App\Enums\RoomType::PRIVATE_ROOM)
                @php
                    $user = $item->users->where('id', '!=', Auth::user()->id)->first();
                @endphp
                <li data-room-id="{{ $item->id }}" class="room rooms__item border-b py-3 w-full px-8 flex items-center">
                    <a href="{{ url('/room/' . $item->id) }}" class="block w-full">
                        <div class="flex overflow-hidden items-center w-full gap-3">
                            <img class="w-10 h-10 rounded-full" src="{{ $user->avatar }}" alt="Rounded avatar">
                            <div class="w-full overflow-hidden">
                                <p class="text-lg overflow-hidden whitespace-nowrap w-3/4 text-ellipsis text-blue-600 font-semibold">
                                    {{ $user->full_name }}
                                </p>
                                <p class="message-description text-md overflow-hidden whitespace-nowrap w-3/4 text-ellipsis">
                                    {{ $item->messages->first()->text ?? 'Chưa có tin nhắn nào' }}
                                </p>
                            </div>
                        </div>
                    </a>
                    <button class="button-friend-request" data-dropdown-placement="right">
                        <i class="fas fa-ellipsis-h-alt"></i>
                        <div
                            class="hidden absolute z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dropdown-friend-request">
                            <ul class="text-left py-1 w-full text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownRightButton">
                                <li>
                                    <a href="{{ url('/room/' . $item->id) }}"
                                       class=" block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Mở chat
                                    </a>
                                </li>
                                <li>
                                    <a data-user-id="{{ $item->id }}" data-room-type="{{ $item->room_type }}"  href="#"
                                       class="block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Chặn</a>
                                </li>
                            </ul>
                        </div>
                    </button>
                </li>
            @elseif($item->room_type === \App\Enums\RoomType::GROUP_ROOM)
                <li data-room-id="{{ $item->id }}" class="room rooms__item border-b py-3 w-full px-8 flex items-center">
                    <a href="{{ url('/room/' . $item->id) }}" class="block w-full">
                        <div class="flex overflow-hidden items-center w-full gap-3">
                            <img class="w-10 h-10 rounded-full image-group-room-preview"
                                 src="{{ $item->image ?? '/images/default-avatar.png' }}"
                                 alt="Rounded avatar">
                            <div class="w-full overflow-hidden">
                                <p
                                    class="group-name text-lg overflow-hidden whitespace-nowrap w-3/4 text-ellipsis text-blue-600 font-semibold">
                                    {{ $item->name }}
                                </p>
                                <p class="message-description text-md overflow-hidden whitespace-nowrap w-3/4 text-ellipsis">
                                    {{ $item->messages->first()->text ?? 'Chưa có tin nhắn nào' }}
                                </p>
                            </div>
                        </div>
                    </a>
                    <button class="button-friend-request" data-dropdown-placement="right">
                        <i class="fas fa-ellipsis-h-alt"></i>
                        <div
                            class="hidden absolute z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dropdown-friend-request">
                            <ul class="text-left py-1 w-full text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownRightButton">
                                <li>
                                    <a href="{{ url('/room/' . $item->id) }}"
                                       class="block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Mở chat
                                    </a>
                                </li>
                                <li>
                                    <a data-room-id="{{ $item->id }}" data-room-type="{{ $item->room_type }}" href="#"
                                       class="btn-leave-group block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Rời phòng</a>
                                </li>
                            </ul>
                        </div>
                    </button>
                </li>
            @endif
        @endforeach
    </ul>

</div>
