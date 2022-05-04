<link rel="stylesheet" href="{{ asset('css/sidebar-profile-private.css') }}">

<div id="offcanvas-profile" class="overflow-y-auto">
    <div class="offcanvas__header mb-10">
        <div class="offcanvas__header--title p-4 flex items-center justify-between">
            <p class="text-xl font-semibold">Xem thông tin</p>
            <button type="button"
                    class="offcanvas__toggle text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm px-4 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="offcanvas__header--avatar flex gap-5 flex-col items-center my-5">
            <img class="rounded-full image-group-room-preview" src="{{ $roomAvatar }}" alt="">
            <p class="room-name text-xl font-semibold">{{ $roomName }}</p>
        </div>
    </div>
    <div class="offcanvas__content my-3 px-5">
        <div id="accordion-collapse" data-accordion="collapse">
            <h2 id="accordion-collapse-heading-1">
                <button type="button"
                        class="flex justify-between items-center p-3 w-full font-semibold text-left text-gray-500 rounded"
                        data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                        aria-controls="accordion-collapse-body-1">
                    <span>Tuỳ chỉnh đoạn chat</span>
                    <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                <div
                    class="w-full text-sm font-medium text-gray-900 bg-white rounded rounded-t-none dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <button
                        id="btn-change-name-group"
                        class="w-full flex items-center gap-3 text-left px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600 text-lg font-semibold">
                        <i class="fas fa-edit"></i>
                        Đổi tên đoạn chat
                    </button>
                    <button
                        id="btn-add-member-group"
                        class="w-full flex items-center gap-3 text-left px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600 text-lg font-semibold">
                        <i class="fas fa-plus-circle"></i>
                        Thêm thành viên mới
                    </button>
                    <button
                        class="w-full relative text-left flex items-center gap-3 px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600 text-lg font-semibold">
                        <i class="fas fa-image"></i>
                        Đổi ảnh đại diện
                        <label for="image-group-room" class="cursor-pointer absolute w-full h-full"></label>
                        <input type="file" hidden id="image-group-room">
                    </button>
                </div>
            </div>

            <h2 id="accordion-collapse-heading-2">
                <button type="button"
                        class="flex justify-between items-center p-3 w-full font-semibold text-left text-gray-500 rounded rounded-b-none"
                        data-accordion-target="#accordion-collapse-body-2" aria-expanded="true"
                        aria-controls="accordion-collapse-body-2">
                    <span>Thành viên trong nhóm</span>
                    <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                <ul class="text-sm w-full font-medium text-gray-900 bg-white rounded-t-none border-gray-200 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @foreach($room->users as $u)
                        <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t dark:border-gray-600 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img class="rounded-full w-8 h-8" src="{{ $u->avatar }}" alt="">
                                <p class="text-lg font-semibold w-3/4 text-ellipsis overflow-hidden">{{ $u->full_name }}</p>
                            </div>
                            <button>
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="offcanvas__footer p-5 border-t">
        <p class="text-xl font-semibold mb-3">Settings</p>
        <div class="flex flex-col gap-3">
            <label for="block-toggle" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" id="block-toggle" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Block</span>
            </label>
            <label for="mute-toggle" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" id="mute-toggle" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Mute</span>
            </label>
            <label for="notify-toggle" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" checked id="notify-toggle" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Get Notification</span>
            </label>
        </div>
    </div>
</div>
