import Swal from 'sweetalert2';
import Toastify from 'toastify-js'
import 'sweetalert2/src/sweetalert2.scss';
import "toastify-js/src/toastify.css"

$(() => {
    const userId = document.getElementById('user_id').value;
    const Echo = window.Echo;
    const axios = window.axios;
    const buttonTabs = Array.from(document.querySelectorAll('.nav__top--button'));


    Echo.channel(`add-friend.${userId}`).listen('AddFriendEvent', (data) => {
        $('#list-request-friend').append(renderFriendRequest(data.friend.avatar, data.friend.full_name, data.friend.id, data.description));
        Toastify({
            text: `${data.friend.full_name} sent a friend request`,
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            className: 'toastify-info'
        }).showToast();
        addEventDropdown();
    })

    Echo.channel(`accept-friend.${userId}`).listen('AcceptFriendEvent', (data) => {
        $('#sidebar_friend_list')
            .append(renderFriendItem(
                data.friend.avatar, data.friend.full_name, data.friend.id, `Xin chào ${data.friend.full_name}`));
        Toastify({
            text: `You and ${data.friend.full_name} have become friends`,
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            className: 'toastify-info'
        }).showToast();
        addEventDropdown();
    })

    Echo.channel(`create-room.${userId}`).listen('CreateRoomEvent', (data) => {
        let roomName = null;
        let avatar = null;

        data.room.users.forEach(item => {
            if (item.user_id !== userId) {
                roomName = item.full_name;
                avatar = item.avatar;
            }
        })

        $('#chat_rooms').append(renderChatRoom(avatar, roomName, data.room.id, `Xin chào ${roomName}`));
        addEventDropdown();
    });

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
        const description = $('#description-add-friend');

        axios.post('/user/add-friend-request', {
            email: email.val(),
            description: description.val()
        }, {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
        }).then((response) => {
            email.val('');
            description.val('');
            Toastify({
                text: `Friend request has been sent`,
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                className: 'toastify-success'
            }).showToast();
        }).catch((error) => {
            Toastify({
                text: error.response.data.message,
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                className: 'toastify-error'
            }).showToast();
            email.val('');
            description.val('');
        })
    })

    function renderChatRoom(avatar, full_name, id, message) {
        return `
        <li class="rooms__item border-b py-3 w-full px-8 flex items-center">
            <a href="/room/${id}" class="block w-full">
                <div class="flex overflow-hidden items-center w-full gap-3">
                    <img class="w-10 h-10 rounded-full" src="${avatar}" alt="Rounded avatar">
                    <div class="w-full overflow-hidden">
                        <p
                            class="text-lg overflow-hidden whitespace-nowrap w-2/4 text-ellipsis text-blue-600 font-semibold">
                            ${full_name}
                        </p>
                        <p class="text-md overflow-hidden whitespace-nowrap w-2/4 text-ellipsis">
                            ${message}
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
                            <a href='/room/${id}'
                            class=" block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Open Room</a>
                        </li>
                        <li>
                            <a data-user-id="{{ ${id} }}" href="#"
                            class=" block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Block</a>
                        </li>
                    </ul>
                </div>
            </button>
        </li>
        `
    }

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
                                   class="btn-create-private block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">New Chat</a>
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
        const buttonCreateRoomPrivate = $('.btn-create-private');

        buttonDropdown.unbind();
        buttonAcceptFriendRequest.unbind();
        buttonBlockFriendRequest.unbind();
        buttonBlockFriend.unbind();
        buttonCreateRoomPrivate.unbind();

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
                            Toastify({
                                text: `Accepted friend request!`,
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                className: 'toastify-success'
                            }).showToast();
                        }
                    }).catch((error) => {
                        Toastify({
                            text: `${error.response.data.message}`,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            className: 'toastify-error'
                        }).showToast();
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
                if (result.isConfirmed) {
                    axios.post('/user/block-friend-request', {
                        user_block_id: id
                    }).then((response) => {
                        if (response.data.status === 200) {
                            parent.remove();
                        }
                        Toastify({
                            text: `Cancellation of friend request successfully!`,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            className: 'toastify-success'
                        }).showToast();
                    }).catch((error) => {
                        Toastify({
                            text: `${error.response.data.message}`,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            className: 'toastify-error'
                        }).showToast();
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
                if (result.isConfirmed) {
                    axios.post('/user/block-friend', {
                        user_block_id: id
                    }).then((response) => {
                        if (response.data.status === 200) {
                            parent.remove();
                            Toastify({
                                text: `Unfriended successfully!`,
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                className: 'toastify-success'
                            }).showToast();
                        }
                    }).catch((error) => {
                        Toastify({
                            text: `${error.response.data.message}`,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            className: 'toastify-error'
                        }).showToast();
                    })
                }
            })
        })

        buttonCreateRoomPrivate.click(function (e) {
            e.preventDefault();
            const id = $(this).attr('data-user-id');

            axios.post('/room/create-room-private', {
                user_id: id
            }).then((response) => {
                if (response.data.status === 200) {
                    window.location.href = '/room/' + response.data.data.id;
                }
            }).catch((error) => {
                if (error.response.data.status === 409) {
                    window.location.href = '/room/' + error.response.data.data.id;
                }
            })

            $(document).click(function (e) {
                if (!buttonCreateRoomPrivate.is(e.target) && buttonCreateRoomPrivate.has(e.target).length === 0) {
                    parent.addClass('hidden')
                }
            })
        })
    }

    $('#user_avatar').change((e) => {
        const file = e.target.files[0];
        const fr = new FileReader();
        fr.readAsDataURL(file);
        fr.onload = (e) => {
            $('#user_avatar_preview').attr('src', e.target.result);
        }
    })

    $('#form_edit_profile').submit(function (e) {
        e.preventDefault();
        const full_name = $('#txt_full_name').val();
        const email = $('#txt_email').val();
        const avatar = $('#user_avatar_preview').attr('src');
        const phone = $('#txt_phone').val();
        const address = $('#txt_address').val();
        const country = $('#txt_country').val();
        const data = {
            full_name: full_name,
            email: email,
            avatar: avatar,
            phone: phone,
            address: address,
            country: country
        }
        axios.put('/user/edit-profile', data)
            .then((response) => {
                if (response.data.status === 200) {
                    $('#avatar_user_navigation').attr('src', avatar);
                    Toastify({
                        text: `Profile updated successfully!`,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        className: 'toastify-success'
                    }).showToast();
                }
            })
            .catch((error) => {
                Toastify({
                    text: `${error.response.data.message}`,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    className: 'toastify-error'
                }).showToast();
            })
    })
})
