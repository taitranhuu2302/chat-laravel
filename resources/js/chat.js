$(() => {
    const Echo = window.Echo;
    const axios = window.axios;

    Echo.channel(`chat-room.${roomId}`).listen('ChatEvent', (data) => {
        renderMessage(data.message, data.user);
    })

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

    if (userChat.id !== user.id) {
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
    } else {
        html = `
            <div class="chat__message flex justify-center my-2">
                <p class="chat__message--notify text-gray-500 text-md">
                    ${text}
                </p>
            </div>
        `
    }

    $('#chat-message-list').prepend(html);
}
