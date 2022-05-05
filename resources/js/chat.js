import Swal from "sweetalert2";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css"

$(() => {
    const Echo = window.Echo;
    const axios = window.axios;
    const btnLoadMore = $('#load-more-message');


    Echo.channel(`chat-room.${roomId}`).listen('ChatEvent', (data) => {
        $('#chat-message-list').prepend(renderMessage(data.message, data.user));


        Array.from($('.room')).forEach((room) => {
            const attr = $(room).attr('data-room-id');
            if (attr === roomId) {
                const child = room.getElementsByClassName('message-description')[0];
                child.innerHTML = data.message.text;
            }
        });
    });

    Echo.channel('room-update.' + roomId).listen('UpdateRoomEvent', (data) => {
        $('.room-name').text(data.room.name);
        $('.image-group-room-preview').attr('src', data.room.image ? data.room.image : '/images/default-avatar.png');

        Array.from($('.room')).forEach((room) => {
            const attr = $(room).attr('data-room-id');
            if (attr === roomId) {
                const child = room.getElementsByClassName('group-name')[0];
                child.innerHTML = data.room.name;
            }
        });
    });

    btnLoadMore.click(eventLoadMoreMessage);

    async function eventLoadMoreMessage() {
        const URL = $(this).attr('data-url');
        const nextPage = URL.split('page=')[1];
        const messages = await getMessageApi(roomId, nextPage);

        messages.data.forEach((message) => {
            $('#chat-message-list').append(renderMessage(message, message.user));
        });

        if (messages.next_page_url === null) {
            btnLoadMore.remove();
        } else {
            btnLoadMore.attr('data-url', messages.next_page_url);
        }
    }

    function getMessageApi(roomId, page) {
        return axios.get(`/message/get-message/${roomId}?page=${page}`).then((res) => {
            return res.data.messages;
        }).catch((err) => {
            console.log(err);
        });
    }


    $('#image-group-room').change(function (e) {
        const file = e.target.files[0];
        const fr = new FileReader();

        fr.readAsDataURL(file);
        fr.onload = (e) => {
            axios.put('/room/edit-room', {
                roomId: roomId,
                roomAvatar: e.target.result
            }).then((response) => {
                Toastify({
                    text: `Bạn đã thay đổi ảnh nhóm thành công`,
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    className: 'toastify-success'
                }).showToast();
            }).catch((error) => {
                console.log(error);
            });
        }
    })

    $('#btn-add-member-group').click(function (e) {
        Swal.fire({
            title: 'Thêm thành viên',
            input: 'email',
            inputAttributes: {
                autocapitalize: 'off'
            },

            showCancelButton: true,
            cancelButtonText: 'Hủy',
            confirmButtonText: 'Thêm',
            showLoaderOnConfirm: true,
            preConfirm: (email) => {
                return axios.post('/room/add-member-group', {
                    roomId: roomId,
                    email: email
                }).then((response) => {
                    Toastify({
                        text: `Bạn đã thêm thành công`,
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
                });
            },
        })
    })

    $('#btn-change-name-group').click(function (e) {

        Swal.fire({
            title: 'Đổi tên đoạn chat',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            cancelButtonText: 'Hủy',
            confirmButtonText: 'Đổi',
            showLoaderOnConfirm: true,
            preConfirm: (data) => {
                const request = {
                    roomName: data,
                    roomId: roomId
                }
                return axios.put('/room/edit-room', request)
                    .then(function (response) {
                        Toastify({
                            text: `Bạn đã đổi tên đoạn chat thành công`,
                            duration: 3000,
                            newWindow: true,
                            close: true,
                            gravity: "top",
                            position: "right",
                            className: 'toastify-success'
                        }).showToast();
                    }).catch(function (error) {
                        console.log(error)
                    })
            },
        })
    })

    $('.offcanvas__toggle').click(() => {
        $('#offcanvas-profile').toggleClass('offcanvas__open');
    });

    $('#form-chat').submit(function (e) {
        e.preventDefault();
        const message = $('#txt_message');
        let messageImage = [];
        const imgTag = Array.from($('.room__footer--message-images-item').children('img'));
        imgTag.forEach((item) => {
            messageImage.push(item.src);
        })

        if (messageImage.length <= 0 && message.val().trim().length == 0) {
            message.focus();
            console.log(message.val().trim().length);
            console.log(messageImage);
            return;
        }

        const data = {
            text: message.val(),
            room_id: roomId,
            images: messageImage
        }

        axios.post('/message/send-message', data).then((response) => {
            $('#txt_message').val('');
            messageImage = [];
            $('#list-file-image').html('');
            checkMessageImage();
        }).catch((error) => {
            console.log(error);
        });
    })

    $('#input-message-image').change((e) => {
        const input = $(this);
        const file = e.target.files[0];

        const fr = new FileReader();
        fr.readAsDataURL(file);

        fr.onload = function (e) {
            $('#list-file-image').append(`
            <div class="room__footer--message-images-item relative">
                <img src="${e.target.result}" alt="image"/>
                <button type="button" class="btn-close-image top-1 right-1 absolute w-6 h-6 flex items-center justify-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            `)
            input.val(null);
            btnCloseImage();
            checkMessageImage();
        }
    })

    dropDownEvent();
    checkMessageImage();

    function checkMessageImage() {
        const list = $('#list-file-image');
        const child = list.children().length;
        if (child <= 0) {
            list.addClass('hidden');
        } else {
            list.removeClass('hidden');
        }
    }

    function btnCloseImage() {
        const button = $('.btn-close-image');
        button.click(function () {
            const item = $(this).parent();
            item.remove();
            checkMessageImage();
        });
    }
})


function dropDownEvent() {
    const btnDropdown = $('.btn-dropdown');
    const btnRemoveMember = $('.btn-remove-member');

    btnDropdown.unbind('click');
    btnRemoveMember.unbind('click');

    btnDropdown.click(function (e) {
        const button = $(this);
        const dropdown = $(this).find('.dropdown-menu');

        dropdown.toggleClass('hidden');

        $(document).click(function (e) {
            if (!button.is(e.target) && button.has(e.target).length === 0) {
                dropdown.addClass('hidden');
            }
        });
    });

    btnRemoveMember.click(function (e) {
        const userId = $(this).attr('data-user-id');
        const parent = $(this).parents('.member');

        Swal.fire({
            title: 'Bạn muốn xoá người này ra khỏi nhóm ?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Xoá thành viên',
            denyButtonText: `Huỷ bỏ`,
        }).then((result) => {
            if (result.isConfirmed) {

                const request = {
                    memberId: userId,
                    roomId
                }
                axios.post('/room/leave-group', request).then((response) => {
                    Toastify({
                        text: `Bạn đã xoá thành viên thành công`,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        className: 'toastify-success'
                    }).showToast();
                    parent.remove();
                }).catch((error) => {
                    console.log(error);
                })
            }
        })
    })
}

function renderMessage(message, userChat) {
    const {text, images} = message;
    let html = '';

    if (!userChat) {
        html = `
            <div class="chat__message flex justify-center my-2">
                <p class="chat__message--notify text-gray-500 text-md">
                    ${text}
                </p>
            </div>
        `;
    } else if (userChat.id !== userCurrent.id) {
        html = `
            <div class="room__chat room__chat--left">
                <div class="room__chat--avatar">
                    <img class="w-10 h-10 rounded-full" src="${userChat.avatar}" alt="Rounded avatar">
                </div>
                <div class="room__chat--content">
                    <p className="room__chat--text">${text}</p>
                </div>
            </div>
        `
    } else if (userChat.id === user.id) {
        html = `
             <div class="room__chat room__chat--right">
                <div class="room__chat--avatar">
                    <img class="w-10 h-10 rounded-full" src="${userChat.avatar}" alt="Rounded avatar">
                </div>
                <div class="room__chat--content">
                    <p className="room__chat--text">${text}</p>
                </div>
             </div>
        `
    }

    return html;
}
