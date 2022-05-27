import Swal from 'sweetalert2';
import Toastify from 'toastify-js'
import moment from 'moment';

$(() => {
    let listUserForTask = [];
    const axios = window.axios;
    const taskDetailModal = new Modal(document.getElementById('task-detail-modal'));

    $('#btn-open-input-task').click(function() {
        console.log($('#input-task-edit'))
    })

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
                const taskResponse = response.data.data;
                console.log(taskResponse);
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
                renderTask(taskResponse);
                eventTask();
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

    function setValueTaskOnDetail() {
        const modal = $('#task-detail-modal')
        const data = JSON.parse(modal.attr('data-task'));
        console.log(data)
        modal.find('.detail__left .left__title .title__text').text(data.title ? data.title : 'Chưa có tiêu đề');
        modal.find('.detail__left .left__content p').text(data.content);
    }

    //Event Task
    function eventTask() {
        const btnDeleteTask = $('.btn-delete-task');
        const btnOpenModalTaskDetail = $('button.btn-open-task-detail');
        const btnCloseModalTask = $('.btn-cancel-modal-task');

        btnDeleteTask.unbind('click');
        btnOpenModalTaskDetail.unbind('click');
        btnCloseModalTask.unbind('click');

        btnOpenModalTaskDetail.on('click', function() {
            taskDetailModal.toggle();
            const data = JSON.stringify($(this).data('task'));
            const modal = $('#task-detail-modal');
            modal.removeAttr('data-task');
            modal.attr('data-task', data);
            setValueTaskOnDetail();
        })

        btnCloseModalTask.on('click', function () {
            taskDetailModal.toggle();
        })

        btnDeleteTask.on('click', function () {
            const parent = this.parentElement.parentElement.parentElement.parentElement.parentElement;

            const modal = $(this).parents('#task-detail-modal');

            const data = JSON.parse(modal.attr('data-task'));
            const listTask = [...$('#list-todo-pending').children(), ...$('#list-todo-complete').children(), ...$('#list-todo-in-complete').children()];

            const taskId = data.id;

            Swal.fire({
                title: 'Bạn muốn xoá công việc này ?',
                showCancelButton: true,
                confirmButtonText: 'Xoá',
                cancelButtonText: 'Huỷ',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {

                if (result.isConfirmed) {
                    listTask.forEach(item => {
                        if ($(item).children().attr('data-task-id') === taskId.toString()) {
                            $(item).remove();
                            parent.getElementsByClassName('btn-cancel-modal-task')[0].click();
                        }
                    })
                    axios.delete(`/task/${taskId}`)
                        .then(() => {
                            Toastify({
                                text: `Bạn đã xóa công việc thành công`,
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
                }
            })


        })
    }

    eventTask();

    // render Task
    function renderTask(task) {
        const data = JSON.stringify(task);
        const html = `
         <li class="px-3 border-b py-3">
            <button class="w-full btn-open-task-detail"
                data-task-id="${task.id}"
                data-task='${data}'
            >
                <div class="flex gap-3">
                    <img class="w-10 h-10 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                         src="${task.owner.avatar}" alt="">
                    <div class="flex flex-col gap-1">
                        ${(() => {
            if (task.title) {
                return `<p class="text-xl font-semibold">${task.title}</p>`
            } else {
                return `<p class="text-xl font-semibold text-gray-400">(Không có tiêu đề)</p>`
            }
        })()}
                        <p class="text-sm text-left text-limit-line">${task.content}</p>
                    </div>
                </div>
                <div class="flex justify-between mt-1">
                    <p class="text-sm text-gray-400">Đã nhận</p>
                    <p class="text-sm">Thời hạn: ${(() => {
                        if (task.due_date) {
                            return moment(task.due_date).format('L LTS')
                        } else {
                            return 'Không có thời hạn'
                        }
                    })()}
                    </p>
                </div>
            </button>
        </li>
       `

        if (task.status === 'PENDING') {
            $('#list-todo-pending').prepend(html);
        } else if (task.status === 'COMPLETED') {
            $('#list-todo-complete').prepend(html);
        } else if (task.status === 'IN_COMPLETE') {
            $('#list-todo-in-complete').prepend(html);
        }
    }

})