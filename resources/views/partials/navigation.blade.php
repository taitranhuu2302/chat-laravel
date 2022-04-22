<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/navigation.css') }}">


<div id="navigation" class="flex">
    <div id="nav" class="py-6 flex flex-col items-center justify-between">
        <ul class="nav__top flex flex-col items-center gap-8" data-tabs-toggle="#sidebar">
            <li>
                <a href="/">
                    <i class="nav__top--logo far fa-comment-dots"></i>
                </a>
            </li>
            <li>
                <button id="button-friend" data-tabs-target="#chat" type="button" role="tab" aria-controls="chat" aria-selected="false" data-tooltip-target="tooltip-chat" class="nav__top--button nav__top--active">
                    <i class="nav__top--icon far fa-comment"></i>
                    <div id="tooltip-button" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Chats
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </button>
            </li>
            <li>
                <button id="button-friend" data-tabs-target="#friend" type="button" role="tab" aria-controls="friend" aria-selected="false" data-tooltip-target="tooltip-friend" class="nav__top--button">
                    <i class="nav__top--icon far fa-user"></i>
                    <div id="tooltip-friend" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Friend
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </button>
            </li>
            <li>
                <button id="button-group" data-tabs-target="#group" type="button" role="tab" aria-controls="group" aria-selected="false" data-tooltip-target="tooltip-group" class="nav__top--button">
                    <i class="nav__top--icon far fa-users"></i>
                    <div id="tooltip-group" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Group
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </button>
            </li>
            <li>
                <button id="button-friend-request" data-tabs-target="#friend-request" type="button" role="tab" aria-controls="friend-request" aria-selected="false" data-tooltip-target="tooltip-friend-pending" class="nav__top--button">
                    <i class="nav__top--icon far fa-star"></i>
                    <div id="tooltip-friend-pending" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Friend Request
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </button>
            </li>
        </ul>
        <ul class="nav__bottom">
            <li>
                <button data-dropdown-toggle="dropdown_user" data-dropdown-placement="top">
                    <img class="w-10 h-10 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500" src="{{ Auth::user()->avatar }}" alt="Bordered avatar">
                </button>
                <div id="dropdown_user" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown_user">
                        <li>
                            <a href="#" class="block text-lg font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                        </li>
                        <li>
                            <a href="#" class="block text-lg font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                        </li>
                        <li>
                            <a href="{{ url('/auth/logout') }}" class="block text-lg font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign
                                out</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div id="sidebar">
        <div id="chat" class="hidden" role="tabpanel" aria-labelledby="button-chat">
            <x-sidebar-chat></x-sidebar-chat>
        </div>
        <div id="friend" class="hidden" role="tabpanel" aria-labelledby="button-friend">
            <x-sidebar-friend></x-sidebar-friend>
        </div>
        <div id="group" class="hidden" role="tabpanel" aria-labelledby="button-group">
            <x-sidebar-group></x-sidebar-group>
        </div>
        <div id="friend-request" class="hidden" role="tabpanel" aria-labelledby="button-friend-request">
            <x-sidebar-friend-request></x-sidebar-friend-request>
        </div>
    </div>
</div>
<x-add-friend-modal></x-add-friend-modal>

<script src="{{ asset('js/navigation.js') }}"></script>
<script>
    const buttonTabs = Array.from(document.querySelectorAll('.nav__top--button'));

    buttonTabs.forEach(button => {
        button.addEventListener('click', () => {
            buttonTabs.forEach(btn => {
                btn.classList.remove('nav__top--active');
            })
            button.classList.add('nav__top--active');
        })
    })
</script>