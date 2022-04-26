<div class="h-full flex flex-col">
    <div class="chat__header flex-shrink px-8 pt-5 flex justify-between items-center">
        <p class="text-2xl font-semibold">Chats</p>
        <div class="chat__header--button flex gap-3">
            <button class="border-gray-300 border px-3 py-0.5 rounded">
                <i class="text-xl far fa-users"></i>
            </button>
            <button class="border-gray-300 border px-3 py-0.5 rounded">
                <i class="text-xl fal fa-plus-circle"></i>
            </button>
        </div>
    </div>

    <div class="chat__search flex-shrink p-8">
        <input type="text" placeholder="Search chats"
               class="text-lg bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>

    <ul class="chat__rooms flex flex-col border-t overflow-y-auto flex-grow">
        @foreach($rooms as $item)
            @if($item->room_type === \App\Enums\RoomType::PRIVATE_ROOM)
                @php
                    $user = $item->users->where('id', '!=', Auth::user()->id)->first();
                @endphp
                <li class="rooms__item border-b py-3 w-full px-8 flex items-center">
                    <a href="{{ url('/room/'. $item->id) }}" class="block w-full">
                        <div class="flex overflow-hidden items-center w-full gap-3">
                            <img class="w-10 h-10 rounded-full" src="{{ $user->avatar }}" alt="Rounded avatar">
                            <div class="w-full overflow-hidden">
                                <p
                                    class="text-lg overflow-hidden whitespace-nowrap w-2/4 text-ellipsis text-blue-600 font-semibold">
                                    {{$user->full_name}}
                                </p>
                                <p class="text-md overflow-hidden whitespace-nowrap w-2/4 text-ellipsis">
                                    Xin chào {{ $user->full_name }}
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
                                    <a href="{{ url('/room/'. $item->id) }}"
                                       class=" block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Open Room</a>
                                </li>
                                <li>
                                    <a data-user-id="{{ $user->id }}" href="#"
                                       class=" block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Block</a>
                                </li>
                            </ul>
                        </div>
                    </button>
                </li>
            @endif
        @endforeach
    </ul>
</div>
