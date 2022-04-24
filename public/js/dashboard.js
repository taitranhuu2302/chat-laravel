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
    $('#list-request-friend').append(renderFriendRequest(data.friend.avatar, data.friend.full_name, data.friend.id, "Xin ch\xE0o ".concat(data.friend.full_name)));
    addEventDropdown();
  }); // Change Tab Active

  buttonTabs.forEach(function (button) {
    button.addEventListener('click', function () {
      buttonTabs.forEach(function (btn) {
        btn.classList.remove('nav__top--active');
      });
      button.classList.add('nav__top--active');
    });
  });
  addEventDropdown(); // Submit form add friend

  $('#form-add-friend').submit(function (e) {
    e.preventDefault();
    var email = $('#email-add-friend');
    axios.post('/user/add-friend-request', {
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

  function renderFriendRequest(avatar, full_name, id, message) {
    return "\n        <li class=\"rooms__item border-b py-3 w-full px-8 flex items-center\">\n        <div class=\"flex overflow-hidden items-center w-full gap-3\">\n            <img class=\"w-10 h-10 rounded-full\" src=\"".concat(avatar, "\" alt=\"Rounded avatar\">\n            <div class=\"w-full overflow-hidden\">\n                <p\n                    class=\"text-lg overflow-hidden whitespace-nowrap w-2/4 text-ellipsis text-blue-600 font-semibold\">\n                    ").concat(full_name, "</p>\n                <p class=\"text-md overflow-hidden whitespace-nowrap w-2/4 text-ellipsis\">").concat(message, "</p>\n            </div>\n        </div>\n        <button class=\"button-friend-request\" data-dropdown-placement=\"right\">\n            <i class=\"fas fa-ellipsis-h-alt\"></i>\n            <div\n                class=\"hidden absolute z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dropdown-friend-request\">\n                <ul class=\"text-left py-1 w-full text-sm text-gray-700 dark:text-gray-200\"\n                    aria-labelledby=\"dropdownRightButton\">\n                    <li>\n                        <a data-user-id=\"").concat(id, "\" href=\"#\"\n                            class=\"block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white\">Accept</a>\n                    </li>\n                    <li>\n                        <a data-user-id=\"").concat(id, "\" href=\"#\"\n                            class=\"block text-md font-semibold py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white\">Block</a>\n                    </li>\n                </ul>\n            </div>\n        </button>\n    </li>\n        ");
  }

  function addEventDropdown() {
    $('.button-friend-request i').unbind();
    $('.button-friend-request i').click(function (e) {
      e.preventDefault();
      var button = $(this).parent();
      var parent = button.children('.dropdown-friend-request');
      parent.toggleClass('hidden');
      $(document).click(function (e) {
        if (!button.is(e.target) && button.has(e.target).length === 0) {
          parent.addClass('hidden');
        }
      });
    });
    $('.accept-friend-request').click(function (e) {
      e.preventDefault();
      var id = $(this).attr('data-user-id');
      console.log('Accept: ', id);
      axios.post('/user/accept-friend-request', {
        user_id: userId,
        user_accept_id: id
      }).then(function (response) {
        console.log(response);
      })["catch"](function (error) {
        console.log(error);
      });
    });
    $('.block-friend-request').click(function (e) {
      e.preventDefault();
      var id = $(this).attr('data-user-id');
      console.log('Block: ', id);
    });
  }
});
/******/ })()
;