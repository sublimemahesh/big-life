let userDash = function () {
    "use strict"
    /* Search Bar ============ */
    var screenWidth = $(window).width();
    var screenHeight = $(window).height();
    var handleWebpicker = function () {
        $('#crypto-webticker').webTicker({
            height: '90px',
            duplicate: true,
            startEmpty: false,
            rssfrequency: 4
        });
    }
    return {
        init: function () {
        },
        resize: function () {
        },

        load: function () {
            handleWebpicker();
        },
    }
}();


/* Document.ready Start */
jQuery(document).ready(function () {
    $('[data-bs-toggle="popover"]').popover();
    'use strict';
    userDash.init();

});
/* Document.ready END */

/* Window Load START */
jQuery(window).on('load', function () {
    'use strict';
    userDash.load();
});
/*  Window Load END */
/* Window Resize START */
jQuery(window).on('resize', function () {
    'use strict';
    userDash.resize();
});


var owl = $('.owl-banner');
owl.owlCarousel({
    items: 1,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 1000,
    autoplayHoverPause: true
});


document.querySelectorAll(".copy-el").forEach((copyBtn) => {
    copyBtn.addEventListener("click", function () {
        const parent = this.closest(".copy-text");
        const input = parent.querySelector("input");

        if (input) {
            navigator.clipboard.writeText(input.value).then(() => {
                Toast.fire({
                    icon: "success",
                    title: "Copied to your clipboard",
                });
            });
        }
    });
});

