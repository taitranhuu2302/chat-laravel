$(() => {
    const userId = document.getElementById('user_id').value;
    const Echo = window.Echo;
    const axios = window.axios;
    const buttonTabs = Array.from(document.querySelectorAll('.nav__top--button'));


    const channel = Echo.channel(`add-friend.${userId}`);
    channel.listen('AddFriendEvent', (data) => {
        console.log(data)
        $('#list-request-friend').append(renderFriendRequest(data.friend.avatar, data.friend.full_name, data.friend.id));
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

    // Submit form add friend
    $('#form-add-friend').submit((e) => {
        e.preventDefault();
        const email = $('#email-add-friend');

        axios.post('/user/add-friend', {
            userId: userId,
            email: email.val()
        }, {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
        }).then((response) => {
            email.val('');
        }).catch((error) => {
            console.log(error)
        })
    })

})

const renderFriendRequest = (avatar, full_name, id) => {
    return `
    <li class="rooms__item border-b py-3 w-full px-8 flex items-center">
            <div class="flex overflow-hidden items-center w-full gap-3">
                <img class="w-10 h-10 rounded-full" src="${avatar}"
                     alt="Rounded avatar">
                <div class="w-full overflow-hidden">
                    <p class="text-lg overflow-hidden whitespace-nowrap w-2/4 text-ellipsis text-blue-600 font-semibold">${full_name}</p>
                    <p class="text-md overflow-hidden whitespace-nowrap w-2/4 text-ellipsis">Lorem ipsum dolor
                        sit amet, consectetur adipisicing elit. Animi asperiores corporis repudiandae? Ab
                        dignissimos doloremque expedita ipsa iure minus qui similique tempora vero voluptatem.
                        Adipisci corporis enim nesciunt provident tempora!</p>
                </div>
            </div>
            <button id="dropdown-friend-request" data-user-id="${id}" data-dropdown-toggle="dropdown-friend-request" data-dropdown-placement="right">
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
    `
}

function addEventDropdown() {
    const button = document.getElementById('dropdown-friend-request')
    const dropdown = button.getAttribute('data-dropdown-toggle');
    console.log(dropdown)
}
