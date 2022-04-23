/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/dashboard.js ***!
  \***********************************/
$(function () {
  var userId = document.getElementById('user_id').value;
  var Echo = window.Echo;
  var axios = window.axios;
  var buttonTabs = Array.from(document.querySelectorAll('.nav__top--button'));
  var channel = Echo.channel("add-friend.".concat(userId));
  channel.listen('AddFriendEvent', function (data) {
    console.log(data);
    $('#list-request-friend').append(renderFriendRequest(data.friend.avatar, data.friend.full_name, data.friend.id));
    addEventDropdown();
  }); // Change Tab Active

  buttonTabs.forEach(function (button) {
    button.addEventListener('click', function () {
      buttonTabs.forEach(function (btn) {
        btn.classList.remove('nav__top--active');
      });
      button.classList.add('nav__top--active');
    });
  }); // Submit form add friend

  $('#form-add-friend').submit(function (e) {
    e.preventDefault();
    var email = $('#email-add-friend');
    axios.post('/user/add-friend', {
      userId: userId,
      email: email.val()
    }, {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      'X-Requested-With': 'XMLHttpRequest'
    }).then(function (response) {
      email.val('');
    })["catch"](function (error) {
      console.log(error);
    });
  });
});

var renderFriendRequest = function renderFriendRequest(avatar, full_name, id) {
  return "\n    <li class=\"rooms__item border-b py-3 w-full px-8 flex items-center\">\n            <div class=\"flex overflow-hidden items-center w-full gap-3\">\n                <img class=\"w-10 h-10 rounded-full\" src=\"".concat(avatar, "\"\n                     alt=\"Rounded avatar\">\n                <div class=\"w-full overflow-hidden\">\n                    <p class=\"text-lg overflow-hidden whitespace-nowrap w-2/4 text-ellipsis text-blue-600 font-semibold\">").concat(full_name, "</p>\n                    <p class=\"text-md overflow-hidden whitespace-nowrap w-2/4 text-ellipsis\">Lorem ipsum dolor\n                        sit amet, consectetur adipisicing elit. Animi asperiores corporis repudiandae? Ab\n                        dignissimos doloremque expedita ipsa iure minus qui similique tempora vero voluptatem.\n                        Adipisci corporis enim nesciunt provident tempora!</p>\n                </div>\n            </div>\n            <button id=\"dropdown-friend-request\" data-user-id=\"").concat(id, "\" data-dropdown-toggle=\"dropdown-friend-request\" data-dropdown-placement=\"right\">\n                <i class=\"fas fa-ellipsis-h-alt\"></i>\n            </button>\n            <div id=\"dropdown-friend-request\"\n                 class=\"hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700\">\n                <ul class=\"py-1 text-sm text-gray-700 dark:text-gray-200\" aria-labelledby=\"dropdownRightButton\">\n                    <li>\n                        <a href=\"#\"\n                           class=\"block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white\">Open</a>\n                    </li>\n                    <li>\n                        <a href=\"#\"\n                           class=\"block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white\">Profile</a>\n                    </li>\n                    <li>\n                        <a href=\"#\"\n                           class=\"block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white\">Block</a>\n                    </li>\n                </ul>\n            </div>\n        </li>\n    ");
};

function addEventDropdown() {
  var button = document.getElementById('dropdown-friend-request');
  var dropdown = button.getAttribute('data-dropdown-toggle');
  console.log(dropdown);
}
/******/ })()
;