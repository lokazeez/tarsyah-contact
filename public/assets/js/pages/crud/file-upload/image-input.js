'use strict';

// Class definition
var KTImageInputDemo = function() {
    // Private functions
    var initDemos = function() {
        var images = document.getElementsByClassName('image-input');
        for (var i = 0; i < images.length; i++) {
            new KTImageInput(images[i].id);
        }
    }

    return {
        // public functions
        init: function() {
            initDemos();
        }
    };
}();

KTUtil.ready(function() {
    KTImageInputDemo.init();
});
