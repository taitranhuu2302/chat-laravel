/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/chat.js ***!
  \******************************/
$(function () {
  var Echo = window.Echo;
  var axios = window.axios;
  Echo.channel("chat-room.".concat(roomId)).listen('ChatEvent', function (data) {
    renderMessage(data.message, data.user);
  });
  $('#form-chat').submit(function (e) {
    e.preventDefault();
    var message = $('#txt_message').val();
    var data = {
      text: message,
      room_id: roomId
    };
    axios.post('/message/send-message', data).then(function (response) {
      $('#txt_message').val('');
    })["catch"](function (error) {
      console.log(error);
    });
  });
});

function renderMessage(message, userChat) {
  var text = message.text;
  var html = '';

  if (userChat.id !== user.id) {
    html = "\n            <div class=\"room__chat room__chat--left\">\n                <div class=\"room__chat--avatar\">\n                    <img class=\"w-10 h-10 rounded-full\" src=\"".concat(userChat.avatar, "\" alt=\"Rounded avatar\">\n                </div>\n                <div class=\"room__chat--content\">\n                    <p class=\"room__chat--text\">\n                        ").concat(text, "\n                    </p>\n                </div>\n            </div>\n        ");
  } else if (userChat.id === user.id) {
    html = "\n             <div class=\"room__chat room__chat--right\">\n                <div class=\"room__chat--avatar\">\n                    <img class=\"w-10 h-10 rounded-full\" src=\"".concat(userChat.avatar, "\" alt=\"Rounded avatar\">\n                </div>\n                <div class=\"room__chat--content\">\n                    <p class=\"room__chat--text\">\n                        ").concat(text, "\n                    </p>\n                </div>\n             </div>\n        ");
  } else {
    html = "\n            <div class=\"chat__message flex justify-center my-2\">\n                <p class=\"chat__message--notify text-gray-500 text-md\">\n                    ".concat(text, "\n                </p>\n            </div>\n        ");
  }

  $('#chat-message-list').prepend(html);
}
/******/ })()
;