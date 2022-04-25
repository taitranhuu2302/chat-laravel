import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';

$(() => {
    const userId = document.getElementById('user_id').value;
    const Echo = window.Echo;
    const axios = window.axios;
    const buttonTabs = Array.from(document.querySelectorAll('.nav__top--button'));

    Echo.channel(`add-friend.${userId}`).listen('AddFriendEvent', (data) => {
        $('#list-request-friend').append(renderFriendRequest(data.friend.avatar, data.friend.full_name, data.friend.id, `Xin chào ${data.friend.full_name}`));
        addEventDropdown();
    })

    Echo.channel(`accept-friend.${userId}`).listen('AcceptFriendEvent', (data) => {
        console.log(data)
        $('#sidebar_friend_list')
            .append(renderFriendItem(
                data.friend.avatar, data.friend.full_name, data.friend.id, `Xin chào ${data.friend.full_name}`));
        addEventDropdown();
    })

    // Change Tab Active
    buttonTabs.forEach(button => {
        button.addEventListener('click', () => {
            buttonTabs.forEach(btn => {
                btn.classList.remove('nav__top--active');
            })
            button.classList.add('nav__top--active');
        })
    })
    addEventDropdown();

    // Submit form add friend
    $('#form-add-friend').submit((e) => {
        e.preventDefault();
        const email = $('#email-add-friend');

        axios.post('/user/add-friend-request', {
            email: email.val()
        }, {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
        }).then((response) => {
            email.val('');
            Swal.fire('Success', 'Friend request has been sent', 'success');
        }).catch((error) => {
            console.log(error)
        })
    })

    function renderFriendRequest(avatar, full_name, id, message) {
        return `
        <li class="rooms__item border-b py-3 w-full px-8 flex items-center">
        <div class="flex overflow-hidden items-center w-full gap-3">
            <img class="w-10 h-10 rounded-full" src="${avatar}" alt="Rounded avatar">
            <div class="w-full overflow-hidden">
                <p
                    class="text-lg overflow-hidden whitespace-nowrap w-2/4 text-ellipsis text-blue-600 font-semibold">
                    ${full_name}</p>
                <p class="text-md overflow-hidden whitespace-nowrap w-2/4 text-ellipsis">${message}</p>
            </div>
        </div>
        <button class="button-friend-request" data-dropdown-placement="right">
            <i class="fas fa-ellipsis-h-alt"></i>
            <div
                class="hidden absolute z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dropdown-friend-request">
                <ul class="text-left py-1 w-full text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="dropdownRightButton">
                    <li>
                        <a data-user-id="${id}" href="#"
                            class="accept-friend-request block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Accept</a>
                    </li>
                    <li>
                        <a data-user-id="${id}" href="#"
                            class="block-friend-request block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Block</a>
                    </li>
                </ul>
            </div>
        </button>
    </li>
        `
    }

    function renderFriendItem(avatar, full_name, id, message) {
        return `
            <li class="rooms__item border-b py-3 w-full px-8 flex items-center">
                <div class="flex overflow-hidden items-center w-full gap-3">
                    <img class="w-10 h-10 rounded-full" src="${avatar}" alt="Rounded avatar">
                    <div class="w-full overflow-hidden">
                        <p
                            class="text-lg overflow-hidden whitespace-nowrap w-2/4 text-ellipsis text-blue-600 font-semibold">
                            ${full_name}</p>
                        <p class="text-md overflow-hidden whitespace-nowrap w-2/4 text-ellipsis">
                           ${message}
                        </p>
                    </div>
                </div>
                <button class="button-friend-request" data-dropdown-placement="right">
                    <i class="fas fa-ellipsis-h-alt"></i>
                    <div
                        class="hidden absolute z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dropdown-friend-request">
                        <ul class="text-left py-1 w-full text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownRightButton">
                            <li>
                                <a data-user-id="${id}" href="#"
                                   class="block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">New Chat</a>
                            </li>
                            <li>
                                <a data-user-id="${id}" href="#"
                                   class="block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                            </li>
                            <li>
                                <a data-user-id="${id}" href="#"
                                   class="btn-block-friend block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Block</a>
                            </li>
                        </ul>
                    </div>
                </button>
            </li>
        `
    }

    function addEventDropdown() {
        const buttonDropdown = $('.button-friend-request i');
        const buttonAcceptFriendRequest = $('.accept-friend-request');
        const buttonBlockFriendRequest = $('.block-friend-request');
        const buttonBlockFriend = $('.btn-block-friend');

        buttonDropdown.unbind();
        buttonAcceptFriendRequest.unbind();
        buttonBlockFriendRequest.unbind();
        buttonBlockFriend.unbind();

        buttonDropdown.click(function (e) {
            e.preventDefault();
            const button = $(this).parent();
            const parent = button.children('.dropdown-friend-request');
            parent.toggleClass('hidden')

            $(document).click(function (e) {
                if (!button.is(e.target) && button.has(e.target).length === 0) {
                    parent.addClass('hidden')
                }
            })
        })

        buttonAcceptFriendRequest.click(function (e) {
            e.preventDefault();
            const id = $(this).attr('data-user-id');

            const parent = $(this).parent().parent().parent().parent().parent();

            Swal.fire({
                title: 'Want to accept a friend request??',
                showCancelButton: true,
                confirmButtonText: 'Ok',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.post('/user/accept-friend-request', {
                        user_accept_id: id
                    }).then((response) => {
                        if (response.data.status === 200) {
                            parent.remove();
                            Swal.fire('Accepted friend request!', '', 'success')
                        }
                    }).catch((error) => {
                        console.log(error)
                    })
                }
            })


        })

        buttonBlockFriendRequest.click(function (e) {
            e.preventDefault();
            const id = $(this).attr('data-user-id');

            const parent = $(this).parent().parent().parent().parent().parent();

            Swal.fire({
                title: 'You want to cancel the friend request?',
                showCancelButton: true,
                confirmButtonText: 'Ok',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.post('/user/block-friend-request', {
                        user_block_id: id
                    }).then((response) => {
                        if (response.data.status === 200) {
                            parent.remove();
                        }
                        Swal.fire('Cancellation of friend request successfully!', '', 'success')
                    }).catch((error) => {
                        Swal.fire('Error! An error occurred. Please try again later!', '', 'error')
                    })
                }
            })


        })

        buttonBlockFriend.click(function (e) {
            e.preventDefault();
            const id = $(this).attr('data-user-id');

            const parent = $(this).parent().parent().parent().parent().parent();

            Swal.fire({
                title: 'You want to unfriend?',
                showCancelButton: true,
                confirmButtonText: 'Ok',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.post('/user/block-friend', {
                        user_block_id: id
                    }).then((response) => {
                        if (response.data.status === 200) {
                            parent.remove();
                            Swal.fire('Unfriended successfully!', '', 'success')
                        }
                    }).catch((error) => {
                        Swal.fire('Error! An error occurred. Please try again later!', '', 'error')
                    })
                }
            })
        })
    }

})

