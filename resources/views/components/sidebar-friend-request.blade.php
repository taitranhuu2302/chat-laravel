<div class="h-full flex flex-col">
    <div class="friend-request__header flex-shrink px-8 pt-5 flex justify-between items-center">
        <p class="text-2xl font-semibold">Friend Request</p>
    </div>

    <div class="friend-request__search flex-shrink p-8">
        <input type="text" placeholder="Search here..."
               class="text-lg bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>

    <ul class="friend-request__rooms flex flex-col border-t overflow-y-auto flex-grow">
        <li class="rooms__item border-b py-3 w-full px-8 flex items-center">
            <div class="flex overflow-hidden items-center w-full gap-3">
                <img class="w-10 h-10 rounded-full" src="{{ Auth::user()->profile->avatar }}"
                     alt="Rounded avatar">
                <div class="w-full overflow-hidden">
                    <p class="text-lg overflow-hidden whitespace-nowrap w-2/4 text-ellipsis text-blue-600 font-semibold">{{ Auth::user()->profile->full_name }}</p>
                    <p class="text-md overflow-hidden whitespace-nowrap w-2/4 text-ellipsis">Lorem ipsum dolor
                        sit amet, consectetur adipisicing elit. Animi asperiores corporis repudiandae? Ab
                        dignissimos doloremque expedita ipsa iure minus qui similique tempora vero voluptatem.
                        Adipisci corporis enim nesciunt provident tempora!</p>
                </div>
            </div>
            <button data-dropdown-toggle="dropdown-friend-request" data-dropdown-placement="right">
                <i class="fas fa-ellipsis-h-alt"></i>
            </button>
            <div id="dropdown-friend-request"
                 class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRightButton">
                    <li>
                        <a href="#"
                           class="block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Open</a>
                    </li>
                    <li>
                        <a href="#"
                           class="block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                    </li>
                    <li>
                        <a href="#"
                           class="block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Block</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
