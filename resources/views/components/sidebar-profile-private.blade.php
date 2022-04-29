<link rel="stylesheet" href="{{ asset('css/sidebar-profile-private.css') }}">

<div id="offcanvas-profile">
    <div class="offcanvas__header">
        <div class="offcanvas__header--title p-4 flex items-center justify-between">
            <p class="text-xl font-semibold">Xem thông tin</p>
            <button type="button"
                    class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm px-4 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="offcanvas__header--avatar flex gap-5 flex-col items-center my-5">
            <img class="w-35 h-35 rounded-full" src="{{ $roomAvatar }}" alt="">
            <p class="text-xl font-semibold">{{ $roomName }}</p>
        </div>
    </div>
    <div class="offcanvas__content">
        <div class="offcanvas__content--about">
            <p>{{ $userProfile->profile->about_myself }}</p>
        </div>
    </div>
    <div class="offcanvas__footer"></div>
</div>

<script>
    console.log(@json(($userProfile->profile)));
</script>
