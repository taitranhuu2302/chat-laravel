<div class="h-full flex flex-col">
    <div class="friend-request__header flex-shrink px-8 pt-5 flex justify-between items-center">
        <p class="text-2xl font-semibold">Friend Request</p>
    </div>

    <div class="friend-request__search flex-shrink p-8">
        <input type="text" placeholder="Search here..."
            class="text-lg bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>

    <ul id="list-request-friend" class="friend-request__rooms flex flex-col border-t overflow-y-auto flex-grow">
        @foreach (Auth::user()->friendRequests as $item)
            <li class="rooms__item border-b py-3 w-full px-8 flex items-center">
                <div class="flex overflow-hidden items-center w-full gap-3">
                    <img class="w-10 h-10 rounded-full" src="{{ $item->user->avatar }}" alt="Rounded avatar">
                    <div class="w-full overflow-hidden">
                        <p
                            class="text-lg overflow-hidden whitespace-nowrap w-3/4 text-ellipsis text-blue-600 font-semibold">
                            {{ $item->user->full_name }}</p>
                        <p class="text-md overflow-hidden whitespace-nowrap w-3/4 text-ellipsis">Xin chào
                            {{ $item->user->full_name }}</p>
                    </div>
                </div>
                <button class="button-friend-request" data-dropdown-placement="right">
                    <i class="fas fa-ellipsis-h-alt"></i>
                    <div
                        class="hidden absolute z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dropdown-friend-request">
                        <ul class="text-left py-1 w-full text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownRightButton">
                            <li>
                                <a data-user-id="{{ $item->user->id }}"
                                    class="accept-friend-request block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Accept</a>
                            </li>
                            <li>
                                <a data-user-id="{{ $item->user->id }}"
                                    class="block-friend-request block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Block</a>
                            </li>
                        </ul>
                    </div>
                </button>
            </li>
        @endforeach
    </ul>
</div>
