/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/task.js ***!
  \******************************/
$(function () {
  var listUserForTask = [];
  $('#task-form').submit(function (e) {
    e.preventDefault();
    var data = $(this).serializeArray(); // const request = {
    //    title: data['title']
    // }
  });
  $('#search-user-for-task').autocomplete({
    source: function source(request, response) {
      response($.map(friends, function (item, index) {
        var fullName = item.user.full_name;
        var email = item.user.email;

        if (fullName.toLowerCase().indexOf(request.term.toLowerCase()) > -1 || email.toLowerCase().indexOf(request.term.toLowerCase()) > -1) {
          return {
            label: "".concat(item.user.email, " (").concat(item.user.full_name, ")"),
            value: item.user.email
          };
        } else {
          return null;
        }
      }));
    }
  }, {});
  $('#btn-add-user-for-task').click(function (e) {
    e.preventDefault();
    var email = $('#search-user-for-task');
    var friendObj = friends.filter(function (item) {
      return item.user.email === email.val();
    })[0];

    if (friendObj) {
      listUserForTask.push(friendObj.user.id);

      if (listUserForTask.length < 4) {
        var html = "\n                    <img data-user-id=".concat(friendObj.user.id, " class=\"avatar-user-for-task cursor-pointer w-10 h-10 border-2 border-white rounded-full dark:border-gray-800\"\n                        src=\"").concat(friendObj.user.avatar, "\" alt=\"\">\n                 ");
        $('#list-avatar-user-for-task').prepend(html);
        console.log('Xin chao');
      }

      $('#list-user-in-task-count').text(listUserForTask.length);
      email.val('');
      var avatarUser = $('.avatar-user-for-task');
      avatarUser.unbind('click');
      avatarUser.click(function (e) {
        var userId = $(this).attr('data-user-id');
        $(this).remove();
        listUserForTask = listUserForTask.filter(function (item) {
          return item != userId;
        });
        $('#list-user-in-task-count').text(listUserForTask.length);
      });
    }
  });
});
/******/ })()
;