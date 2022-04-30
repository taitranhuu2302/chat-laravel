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
            <img class="rounded-full" src="{{ $roomAvatar }}" alt="">
            <p class="text-xl font-semibold">{{ $roomName }}</p>
        </div>
    </div>
    <div class="offcanvas__content px-5">
        <div class="offcanvas__content--about mb-5">
            <p class="text-xl font-semibold mb-2">Giới thiệu</p>
            <p class="text-md text-gray-500">{{ $userProfile->profile->about_myself ? $userProfile->profile->about_myself : 'Chưa cập nhật' }}</p>
        </div>
        <div class="offcanvas__content--email mb-5">
            <p class="text-xl font-semibold mb-2">Email</p>
            <p class="text-md text-gray-500">{{ $userProfile->email ? $userProfile->email : 'Chưa cập nhật' }}</p>
        </div>
        <div class="offcanvas__content--phone mb-5">
            <p class="text-xl font-semibold mb-2">Số điện thoại</p>
            <p class="text-md text-gray-500">{{ $userProfile->profile->phone ? $userProfile->profile->phone : 'Chưa cập nhật' }}</p>
        </div>
        <div class="offcanvas__content--address mb-5">
            <p class="text-xl font-semibold mb-2">Địa chỉ</p>
            <p class="text-md text-gray-500">{{ $userProfile->profile->address ?  $userProfile->profile->address : 'Chưa cập nhật' }}</p>
        </div>
        <div class="offcanvas__content--country mb-5">
            <p class="text-xl font-semibold mb-2">Quốc gia</p>
            <p class="text-md text-gray-500">{{ $userProfile->profile->country ? $userProfile->profile->country : 'Chưa cập nhật' }}</p>
        </div>
        <div class="offcanvas__content--social mb-5">
            <p class="text-xl font-semibold mb-2">Kết nối</p>
            <div class="flex gap-5">
                <a href="#" target="_blank"
                   class="flex items-center bg-blue-700 w-8 h-8 flex items-center justify-center rounded">
                    <i class="fab fa-facebook-f text-white"></i>
                </a>
                <a href="#" target="_blank"
                   class="flex items-center bg-blue-500 w-8 h-8 flex items-center justify-center rounded">
                    <i class="fab fa-twitter text-white"></i>
                </a>
                <a href="#" target="_blank"
                   class="flex items-center bg-red-500 w-8 h-8 flex items-center justify-center rounded">
                    <i class="fab fa-instagram text-white"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="offcanvas__footer p-5 border-t">
        <p class="text-xl font-semibold mb-3">Settings</p>
        <div class="flex flex-col gap-3">
            <label for="block-toggle" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" id="block-toggle" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Block</span>
            </label>
            <label for="mute-toggle" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" id="mute-toggle" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Mute</span>
            </label>
            <label for="notify-toggle" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" checked id="notify-toggle" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Get Notification</span>
            </label>
        </div>
    </div>
</div>
