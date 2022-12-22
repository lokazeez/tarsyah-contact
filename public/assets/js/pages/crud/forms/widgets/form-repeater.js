// Class definition
var KTFormRepeater = function() {

    // Private functions
    var demo1 = function() {
        $('.kt_repeater').repeater({
            repeaters: [{
                // (Required)
                // Specify the jQuery selector for this nested repeater
                selector: '.inner-repeater'
            }],
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                let cColors = $('.favColor');
                cColors.each(function () {
                    $(this).on('input', function () {
                        console.log($(this).val());
                        $(this).parent().find('input.hex').val($(this).val());
                    })
                })
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    }

    let demo2 = function() {
        $('.kt_repeater_edit').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                let cColors = $('.favColor');
                cColors.each(function () {
                    $(this).on('input', function () {
                        console.log($(this).val());
                        $(this).parent().find('input.hex').val($(this).val());
                    });
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    }

    return {
        // public functions
        init: function() {
            demo1();
            demo2();
        }
    };
}();

jQuery(document).ready(function() {
    KTFormRepeater.init();
});
