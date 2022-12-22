/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/notifications.js ***!
  \***************************************/
$('document').ready(function () {
  autoComplete();
  var allUsersCheck = $('input[name="send_to_all_users"]');
  allUsersCheck.prop('checked', true);
  $('#user_id_section').hide();
  allUsersCheck.on('change', function () {
    $('#user_id').val('').change();

    if ($(this).is(":checked")) {
      $('#user_id_section').slideUp();
    } else {
      $('#user_id_section').slideDown();
    }
  });
});

function autoComplete() {
  var url;
  var element = $('#user_id');
  url = element.attr('url');
  element.select2({
    placeholder: "search for user",
    ajax: {
      url: url,
      dataType: 'json',
      data: function data(params) {
        // Query parameters will be ?search=[term]
        return {
          search: params.term
        };
      }
    },
    minimumInputLength: 1
  });
}

jQuery(document).ready(function () {
  var $registerForm = $('#sheen_value_form');

  if ($registerForm.length) {
    $registerForm.validate({
      rules: {
        'title:en': {
          required: true
        },
        'message:en': {
          required: true
        },
        user_id: {
          required: false,
          validUrl: false,
          url: false
        }
      }
    });
    var nameAr = $('input[name="title:ar"]');
    $registerForm.on('submit', function (e) {
      if (nameAr.val() === '') {
        e.preventDefault();
        $('#ar-tab-1').trigger('click');
        nameAr.addClass('is-invalid');
        nameAr.parent().append('<div class="invalid-feedback text-right">Title is required</div>');
        return false;
      }
    });
  }
});
/******/ })()
;