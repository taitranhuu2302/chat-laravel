import Swal from 'sweetalert2';
import Toastify from 'toastify-js'

$(() => {
    let listUserForTask = [];
    const axios = window.axios;

    $('#task-form').submit(function (e) {
        e.preventDefault();
        const title = $('#title-task');
        const content = $('#content-task');
        const dueDate = $('#due-date-task');

        const request = {
            title: title.val(),
            content: content.val(),
            due_date: dueDate.val(),
            users: listUserForTask
        }

        axios.post('/task', request)
            .then((response) => {
                console.log(response);
                title.val('');
                content.val('');
                dueDate.val('');
                listUserForTask = [];
                $('#list-user-in-task-count').text(listUserForTask.length);
                const wrapperListAvatar = $('#list-avatar-user-for-task');
                wrapperListAvatar.empty();
                wrapperListAvatar.append(`
                <a id="list-user-in-room-count"
                   class="flex items-center justify-center w-10 h-10 text-xs font-medium text-white bg-gray-700 border-2 border-white rounded-full hover:bg-gray-600 dark:border-gray-800"
                   href="#">+0</a>
                `);
                Toastify({
                    text: `Bạn đã tạo công việc thành công`,
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    className: 'toastify-success'
                }).showToast();
            })
            .catch((error) => {
                console.log(error);
            });
    })

    $('#search-user-for-task').autocomplete({
        source: function (request, response) {
            response($.map(friends, function (item, index) {

                const fullName = item.user.full_name;
                const email = item.user.email;

                if (fullName.toLowerCase().indexOf(request.term.toLowerCase()) > -1 || email.toLowerCase().indexOf(request.term.toLowerCase()) > -1) {
                    return {
                        label: `${item.user.email} (${item.user.full_name})`,
                        value: item.user.email
                    }
                } else {
                    return null;
                }
            }))
        }
    }, {});
    $('#btn-add-user-for-task').click(function (e) {
        e.preventDefault();

        const email = $('#search-user-for-task');
        const friendObj = friends.filter(item => item.user.email === email.val())[0];

        if (friendObj) {
            listUserForTask.push(friendObj.user.id);


            if (listUserForTask.length < 4) {
                const html = `
                    <img data-user-id=${friendObj.user.id} class="avatar-user-for-task cursor-pointer w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                        src="${friendObj.user.avatar}" alt="">
                 `;
                $('#list-avatar-user-for-task').prepend(html);
            }

            $('#list-user-in-task-count').text(listUserForTask.length);
            email.val('');
            const avatarUser = $('.avatar-user-for-task');
            avatarUser.unbind('click');
            avatarUser.click(function (e) {
                const userId = $(this).attr('data-user-id');
                $(this).remove();
                listUserForTask = listUserForTask.filter(item => item != userId);
                $('#list-user-in-task-count').text(listUserForTask.length);
            })
        }
    })
})
