(function ($) {
    'use strict';

    function kt_masonry($masonry) {
        var t = $masonry.attr("data-cols");
        if ( t == "1" ) {
            var n = $masonry.width(),
                r = 1;
            return r
        }
        if ( t == "2" ) {
            var n = $masonry.width(),
                r = 2;
            if ( n < 600 ) r = 1;
            return r
        } else if ( t == "3" ) {
            var n = $masonry.width(),
                r = 3;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 ) r = 3;
            return r
        } else if ( t == "4" ) {
            var n = $masonry.width(),
                r = 4;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 ) r = 4;
            return r
        } else if ( t == "5" ) {
            var n = $masonry.width(),
                r = 5;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 && n < 1140 ) r = 4;
            else if ( n >= 1140 ) r = 5;
            return r
        } else if ( t == "6" ) {
            var n = $masonry.width(),
                r = 5;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 && n < 1160 ) r = 4;
            else if ( n >= 1160 ) r = 6;
            return r
        } else if ( t == "8" ) {
            var n = $masonry.width(),
                r = 5;

            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 && n < 1160 ) r = 4;
            else if ( n >= 1160 ) r = 8;
            return r
        }
    };

    function cp_s($masonry) {
        var t = kt_masonry($masonry),
            n = $masonry.width(),
            r = n / t;
        r     = Math.floor(r);
        $masonry.find(".item-portfolio").each(function (t) {
            $(this).css({
                width: r + "px"
            });
        });
    };

    function cp_masonry() {
        $('.cp-portfolio').each(function () {
            var $masonry    = $(this).find('.portfolio-grid'),
                $layoutMode = $masonry.attr('data-layoutMode');
            cp_s($masonry);
            // init Isotope
            var $grid = $masonry.isotope({
                itemSelector: '.item-portfolio',
                layoutMode: $layoutMode,
                itemPositionDataEnabled: true
            });

            $grid.imagesLoaded().progress(function () {
                $grid.isotope({
                    itemSelector: '.item-portfolio',
                    layoutMode: $layoutMode,
                    itemPositionDataEnabled: true
                });
            });

            $(this).find('.portfolio_fillter .item-fillter').on('click', function () {
                var $filterValue = $(this).attr('data-filter');
                $grid.isotope({
                    filter: $filterValue
                });
                $(this).closest('.cp-portfolio').find('.portfolio_fillter .item-fillter').removeClass('fillter-active');
                $(this).addClass('fillter-active');
            });

        });
    };

    $(window).resize(function () {
        cp_masonry();
    });

    window.addEventListener('load',
        function (ev) {
            cp_masonry();
        }, false);

})(window.jQuery);