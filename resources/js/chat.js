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
        $('.image-group-room-preview').attr('src', data.room.image);

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

    $('#btn-change-name-group').click(function (e) {

        Swal.fire({
            title: 'Đổi tên đoạn chat',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
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
        const message = $('#txt_message').val();
        const data = {
            text: message,
            room_id: roomId
        }

        axios.post('/message/send-message', data).then((response) => {
            $('#txt_message').val('');
        }).catch((error) => {
            console.log(error);
        });
    })
})

function renderMessage(message, userChat) {
    const {text} = message;
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
                    <p class="room__chat--text">
                        ${text}
                    </p>
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
                    <p class="room__chat--text">
                        ${text}
                    </p>
                </div>
             </div>
        `
    }

    return html;
}
