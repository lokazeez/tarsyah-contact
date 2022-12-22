/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/roles.js ***!
  \*******************************/
jQuery(document).ready(function () {
  var $registerForm = $('#sheen_value_form');

  if ($registerForm.length) {
    $registerForm.validate({
      rules: {
        name: {
          required: true
        }
      },
      messages: {
        name: {
          required: 'please enter name'
        }
      }
    });
  }
});
/******/ })()
;