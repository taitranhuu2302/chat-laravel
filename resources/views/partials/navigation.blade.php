<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/navigation.css') }}">


<div id="navigation">
    <div id="nav" class="flex flex-col justify-between py-5">
        <ul class="flex flex-col items-center gap-8" data-tabs-toggle="#sidebar" role="tablist">
            <li>
                <svg style="fill: #4eac6d" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                     viewBox="0 0 24 24">
                    <path
                        d="M8.5,18l3.5,4l3.5-4H19c1.103,0,2-0.897,2-2V4c0-1.103-0.897-2-2-2H5C3.897,2,3,2.897,3,4v12c0,1.103,0.897,2,2,2H8.5z M7,7h10v2H7V7z M7,11h7v2H7V11z"></path>
                </svg>
            </li>
            <li>
                <button class="button-tab active" data-tooltip-target="button-profile" data-tabs-target="#tab-profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">
                    <i class="far fa-user-circle icon-nav "></i>
                </button>
                <div id="button-profile" role="tooltip"
                     class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Profile
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </li>
            <li>
                <button class="button-tab" data-tooltip-target="button-chats" data-tabs-target="#tab-chat" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">
                    <i class="far fa-comments-alt icon-nav"></i>
                </button>
                <div id="button-chats" role="tooltip"
                     class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Chats
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </li>
            <li>
                <button class="button-tab" data-tooltip-target="button-contacts" data-tabs-target="#tab-contact"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">
                    <i class="fal fa-address-card icon-nav"></i>
                </button>
                <div id="button-contacts" role="tooltip"
                     class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Contacts
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </li>
            <li>
                <button class="button-tab" data-tooltip-target="button-friend-pending"
                        data-tabs-target="#tab-friend-pending" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">
                    <i class="fal fa-user-alt icon-nav"></i>
                </button>
                <div id="button-friend-pending" role="tooltip"
                     class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Friend Pending
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </li>
            <li>
                <button class="button-tab" data-tooltip-target="button-settings" data-tabs-target="#tab-setting"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">
                    <i class="far fa-cog icon-nav"></i>
                </button>
                <div id="button-settings" role="tooltip"
                     class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Settings
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </li>
        </ul>
        <ul class="flex flex-col items-center">
            <li>
                <button data-dropdown-toggle="dropdown_user" data-dropdown-placement="top">
                    <img class="w-10 h-10 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                         src="{{ Auth::user()->profile->avatar }}" alt="Bordered avatar">
                </button>
                <div id="dropdown_user"
                     class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownTopButton">
                        <li>
                            <a href="#"
                               class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white font-semibold">Profile</a>
                        </li>
                        <li>
                            <a href="#"
                               class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white font-semibold">Settings</a>
                        </li>
                        <li>
                            <a href="{{ url('/auth/logout') }}"
                               class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white font-semibold">Sign
                                out</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div id="sidebar">
        <div id="tab-profile" class="hidden" role="tabpanel" aria-labelledby="profile-tab">
            <div class="profile_header">
                Profile
            </div>
        </div>
        <div id="tab-chat" class="hidden">
            <div class="profile_header">
                Chat
            </div>
        </div>
        <div id="tab-friend-pending" class="hidden">
            <div class="profile_header">
                friend-pending
            </div>
        </div>
        <div id="tab-contact" class="hidden">
            <div class="profile_header">
                Contact
            </div>
        </div>
        <div id="tab-setting" class="hidden">
            <div class="profile_header">
                Setting
            </div>
        </div>
    </div>
</div>

<script>
    const tabs = Array.from(document.querySelectorAll('.button-tab'));
    tabs.forEach((button) => {
        button.addEventListener('click', async () => {
            await tabs.forEach((tab) => {
                tab.classList.remove('active');
            });
            button.classList.add('active');
        })
    })

</script>
