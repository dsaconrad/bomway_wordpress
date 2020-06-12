(function ( $ ) {
    'use strict';

    /* ================ MENU SETING ==================== */

    //Menu fixed
    function cp_sticky() {
        if ( maxstoreplus_global.opt_enable_main_menu_sticky == 0 ) {
            return;
        }

        var widthDevice   = $( window ).width(),
            _mainHeader   = $( '#header-top-fixed' ),
            _headerOffset = $( '.header-menu' ).length ? $( '.header-menu' ).offset().top : 0,
            _height       = $( '#header-primary' ).height() + 100;

        if ( maxstoreplus_global.opt_style_header == 'style-02' ) {
            if ( widthDevice > 1024 ) {
                if ( $( window ).scrollTop() > _height ) {
                    $( '.header.header-style-2' ).addClass( 'header-bg' );
                } else {
                    $( '.header.header-style-2' ).removeClass( 'header-bg' );
                }
            } else {
                $( '.header.header-style-2' ).removeClass( 'header-bg' );
            }
        } else {
            if ( widthDevice > 1024 ) {
                if ( $( window ).scrollTop() > _height ) {
                    _mainHeader.addClass( 'header-fixed' );
                } else {
                    _mainHeader.removeClass( 'header-fixed' );
                }
            } else {
                _mainHeader.removeClass( 'header-fixed' );
            }
        }
    }

    /* ---------------------------------------------
     Full Height
     --------------------------------------------- */
    function height_full() {
        (function ( $ ) {
            var heightoff    = 0,
                heightHeader = $( '.main-header' ).outerHeight(),
                heightSlide;
            if ( $( '.header' ).hasClass( 'trans' ) ) {
                heightSlide = $( window ).outerHeight() - heightoff;
            } else {
                heightSlide = $( window ).outerHeight() - heightoff - heightHeader;
            }
            $( ".full-height" ).css( "height", heightSlide );
            $( ".min-full-height" ).css( "min-height", heightSlide );
        })( jQuery );
    }

    function resize_height() {
        var _array_height = Array(),
            _contentID    = Array();
        $( '.resize-height' ).each( function () {
            var _ID = $( this ).attr( 'id' );
            _contentID.push( _ID );
        } );

        $.each( _contentID, function ( key, value ) {
            $( '#' + value ).find( '.info-product' ).each( function () {
                var _height = $( this ).height();
                _array_height.push( _height );
            } );
            var _maxArray = Math.max.apply( Math, _array_height );
            if ( _maxArray >= 0 ) {
                $( '#' + value ).find( '.info-product' ).css( "height", _maxArray );
            }
        } );
    }

    function maxstoreplus_get_scrollbar_width() {
        var $inner = jQuery( '<div style="width: 100%; height:200px;">test</div>' ),
            $outer = jQuery( '<div style="width:200px;height:150px; position: absolute; top: 0; left: 0; visibility: hidden; overflow:hidden;"></div>' ).append( $inner ),
            inner  = $inner[0],
            outer  = $outer[0];
        jQuery( 'body' ).append( outer );
        var width1 = inner.offsetWidth;
        $outer.css( 'overflow', 'scroll' );
        var width2 = outer.clientWidth;
        $outer.remove();
        return (width1 - width2);
    };

    function dropdown_menu() {
        $( '.primary-menu' ).each( function () {
            var _main = $( this );
            _main.children( '.menu-item.parent' ).each( function () {
                var curent = $( this ).find( '.sub-menu' );
                $( this ).children( '.caret' ).on( 'click', function () {
                    $( this ).parent().children( '.sub-menu' ).slideToggle( 500 );
                    _main.find( '.sub-menu' ).not( curent ).slideUp( 500 );
                    $( this ).parent().toggleClass( 'show-submenu' );
                    _main.find( '.menu-item.parent' ).not( $( this ).parent() ).removeClass( 'show-submenu' );
                } );
                var next_curent = $( this ).find( '.sub-menu' );
                next_curent.children( '.menu-item.parent' ).each( function () {
                    var child_curent = $( this ).find( '.sub-menu' );
                    $( this ).children( '.caret' ).on( 'click', function () {
                        $( this ).parent().parent().find( '.sub-menu' ).not( child_curent ).slideUp( 500 );
                        $( this ).parent().children( '.sub-menu' ).slideToggle( 500 );
                        $( this ).parent().parent().find( '.menu-item.parent' ).not( $( this ).parent() ).removeClass( 'show-submenu' );
                        $( this ).parent().toggleClass( 'show-submenu' );
                    } )
                } );
            } );
        } );
    };

    /* Show submenu */
    function show_submenu() {
        var window_size = jQuery( 'body' ).innerWidth();
        if ( window_size <= 1024 ) {
            /* ON MOBILE */

            $( '.maxstoreplus_custommenu.layout1 .menu .menu-item' ).on( 'click', function () {
                $( this ).parent().find( '.menu-item' ).removeClass( 'show-submenu' );
                $( this ).toggleClass( 'show-submenu' );
                return false;
            } );
            $( 'body' ).on( 'click', function () {
                $( '.maxstoreplus_custommenu.layout1 .menu .menu-item' ).removeClass( 'show-submenu' );
            } );
        } else {
            if ( maxstoreplus_global.opt_style_header != 'style-02' ) {
                $( document ).on( 'mouseenter', '.ms-main-menu .menu-item', function () {
                    $( this ).addClass( 'show-submenu' );
                } ).on( 'mouseleave', '.ms-main-menu .menu-item', function () {
                    $( this ).removeClass( 'show-submenu' );
                } );
            }
            $( document ).on( 'mouseenter', '.maxstoreplus_custommenu.layout1 .menu .menu-item', function () {
                $( this ).addClass( 'show-submenu' );
            } ).on( 'mouseleave', '.maxstoreplus_custommenu.layout1 .menu .menu-item', function () {
                $( this ).removeClass( 'show-submenu' );
            } );
        }
    }

    /* Menu mobile */
    function append_mobile() {
        if ( $( '#header .navigation' ).length > 0 ) {
            //$(this).remove();
            $( '#header .navigation' ).clone().appendTo( '#box-mobile-menu .box-inner' );
            if ( $( '#box-mobile-menu .lazy' ).length ) {
                $( '#box-mobile-menu .lazy' ).init_lazy_load();
            }
        }
        if ( $( '#header .navigation' ).length > 0 && $( '#header-top-fixed .menu-fixed-inner' ).is( ':empty' ) ) {
            $( '#header .navigation' ).clone().appendTo( '#header-top-fixed .menu-fixed-inner' );
            if ( $( '#header-top-fixed .lazy' ).length ) {
                $( '#header-top-fixed .lazy' ).init_lazy_load();
            }
        }
        $( '#toggle-menu-style-2' ).on( 'click', function () {
            $( 'body' ).addClass( 'ms-header-full-fixed' );
            return false;
        } );
        $( "#drop-menu-style-2 .close-menu" ).on( "click", function () {
            $( 'body' ).removeClass( 'ms-header-full-fixed' );
            return false;
        } );

        function action_addClass() {
            $( 'body' ).addClass( 'ms-sidebar-mobile' );
            return false;
        }

        function action_removeClass() {
            $( 'body' ).removeClass( 'ms-sidebar-mobile' );
            $( '#box-mobile-menu .primary-menu' ).find( 'li' ).removeClass( "show-submenu" );
            $( '#box-mobile-menu .primary-menu' ).find( '.sub-menu' ).slideUp( 400 );
            return false;
        }

        $( "#box-mobile-menu .open-menu" ).on( 'click', action_addClass );
        $( "#box-mobile-menu .close-menu,.body-ovelay, .header .search-bar .close-touch" ).on( 'click', action_removeClass );
    };

    /* ================ MENU SETING ==================== */

    /* ---------------------------------------------
     Owl carousel
     --------------------------------------------- */
    $.fn.init_carousel = function () {
        $( this ).each( function () {
            var owl    = $( this ),
                config = $( this ).data();

            config.navText = [ '<i class="flaticon-arrows-left"></i>', '<i class="flaticon-arrows-right"></i>' ];

            if ( $( this ).find( '.product-item' ).hasClass( 'content-product-style-2' ) ) {
                config.center = true;
            }

            if ( $( this ).hasClass( 'dots-custom' ) ) {
                var _parent        = $( this ).closest( '.woocommerce-product-gallery' ),
                    _dotsContainer = _parent.find( '.cp-dots-custom' );

                config.dotsContainer = _dotsContainer;
            }

            var animateOut = $( this ).data( 'animateout' ),
                animateIn  = $( this ).data( 'animatein' );
            if ( typeof animateOut != 'undefined' ) {
                config.animateOut = animateOut;
            }

            if ( typeof animateIn != 'undefined' ) {
                config.animateIn = animateIn;
            }

            owl.on( 'translated.owl.carousel', function ( event ) {
                if ( $( event.target ).find( '.lazy' ).length ) {
                    $( event.target ).find( '.lazy' ).init_lazy_load();
                }
            } );

            owl.on( 'initialized.owl.carousel', function ( event ) {
                if ( $( this ).hasClass( 'dots-custom' ) ) {
                    bxslider_init();
                }
            } );

            owl.owlCarousel( config );
        } );
    };

    /* ---------------------------------------------
     Woocommerce Quantily
     --------------------------------------------- */
    if ( !String.prototype.getDecimals ) {
        String.prototype.getDecimals = function () {
            var num   = this,
                match = ('' + num).match( /(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/ );
            if ( !match ) {
                return 0;
            }
            return Math.max( 0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0) );
        };
    }
    $( document ).on( 'click', '.quantity .plus, .quantity .minus', function ( e ) {
        e.preventDefault();
        // Get values
        var $qty       = $( this ).closest( '.quantity' ).find( '.qty' ),
            currentVal = parseFloat( $qty.val() ),
            max        = parseFloat( $qty.attr( 'max' ) ),
            min        = parseFloat( $qty.attr( 'min' ) ),
            step       = $qty.attr( 'step' );

        // Format values
        if ( !currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = '1';

        // Change the value
        if ( $( this ).is( '.plus' ) ) {
            if ( max && (currentVal >= max) ) {
                $qty.val( max );
            } else {
                $qty.val( (currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
            }
        } else {
            if ( min && (currentVal <= min) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( (currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
            }
        }

        // Trigger change event
        $qty.trigger( 'change' );
    } );

    //Bg Parallax
    function parallaxInit() {
        //Mobile Detect
        if ( $( '.bg-parallax' ).length ) {
            var testMobile,
                isMobile = {
                    Android: function () {
                        return navigator.userAgent.match( /Android/i );
                    },
                    BlackBerry: function () {
                        return navigator.userAgent.match( /BlackBerry/i );
                    },
                    iOS: function () {
                        return navigator.userAgent.match( /iPhone|iPad|iPod/i );
                    },
                    Opera: function () {
                        return navigator.userAgent.match( /Opera Mini/i );
                    },
                    Windows: function () {
                        return navigator.userAgent.match( /IEMobile/i );
                    },
                    any: function () {
                        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                    }
                };

            testMobile = isMobile.any();
            if ( testMobile == null ) {
                $( '.bg-parallax' ).each( function () {
                    $( this ).parallax( '50%', 0.3 );
                } );
            }

            if ( isMobile.iOS() ) {
                $( '.bg-parallax' ).each( function () {
                    $( this ).css( {
                        "background-size": "auto 100%",
                        "background-attachment": "scroll"
                    } );
                } );
            }
        }
    };

    $( ".portfolio_fillter .item-fillter.fillter-active" ).trigger( "click" );


    //ACORDION

    if ( $( ".ms-accordion" ).length ) {
        $( ".ms-accordion" ).each( function () {
            var _main = $( this );
            _main.find( '.cat-parent' ).each( function () {
                $( this ).append( '<span class="carets fa fa-angle-down"></span>' );
            } );
            _main.children( '.cat-parent' ).each( function () {

                var curent = $( this ).find( '.children' );
                $( this ).children( '.carets' ).on( 'click', function () {
                    $( this ).parent().children( '.children' ).slideToggle( 400 );
                    _main.find( '.children' ).not( curent ).slideUp( 400 );
                } );
                var next_curent = $( this ).find( '.children' );
                next_curent.children( '.cat-parent' ).each( function () {
                    var child_curent = $( this ).find( '.children' );
                    $( this ).children( '.carets' ).on( 'click', function () {
                        $( this ).parent().parent().find( '.children' ).not( child_curent ).slideUp( 400 );
                        $( this ).parent().children( '.children' ).slideToggle( 400 );
                    } )
                } );
            } );
        } );
    }

    //Time countdown
    function countdown() {
        if ( $( '.cp-countdown' ).length ) {
            $( '.cp-countdown' ).each( function () {

                var _this = $( this ),
                    _date = _this.attr( 'data-time' );

                _this.countdown( _date, function ( event ) {
                    var _hour   = event.strftime( '%-H' ),
                        _minute = event.strftime( '%-M' ),
                        _second = event.strftime( '%-S' ),
                        _day    = event.strftime( '%-D' );

                    _this.find( '.day' ).html( _day + '<span>days</span>' );
                    _this.find( '.hour' ).html( _hour + '<span>hours</span>' );
                    _this.find( '.minute' ).html( _minute + '<span>mins</span>' );
                    _this.find( '.second' ).html( _second + '<span>secs</span>' );
                } );
            } );
        }
        if ( $( '.cp-time-countdown' ).length ) {
            $( '.cp-time-countdown' ).each( function () {
                var _dateEnd = $( this ).data( 'date' );
                _dateEnd     = Date.parse( _dateEnd ) / 1000;

                var _dataNow = new Date();
                _dataNow     = _dataNow.getTime() / 1000;

                $( this ).final_countdown( {
                    'start': 1362139200,
                    'end': _dateEnd,
                    'now': _dataNow,
                    seconds: {
                        borderColor: '#ff4949',
                        borderWidth: '2'
                    },
                    minutes: {
                        borderColor: '#ff4949',
                        borderWidth: '2'
                    },
                    hours: {
                        borderColor: '#ff4949',
                        borderWidth: '2'
                    },
                    days: {
                        borderColor: '#ff4949',
                        borderWidth: '2'
                    }
                } );
            } );
        }
    }


    /*--------------------------------------------
     SHOP
     ----------------------------------------------*/

    //Banner slide shop
    if ( $( '.slide-banner' ).length ) {
        $( '.slide-banner' ).find( '.banner-item' ).each( function () {
            var _imgBanner = $( this ).data( 'bg' );
            $( this ).css( 'background-image', 'url(' + _imgBanner + ')' );
        } )
    }
    /* ---------------------------------------------
     LOADMORE PRODUCTS
     --------------------------------------------- */

    $( document ).on( 'click', '.ms-button-loadmore', function () {

        // get post ID in array
        var _private_ID      = $( this ).attr( 'id' ).replace( 'private-', '' ),
            _except_post_ids = Array();

        $( '#content-' + _private_ID ).find( '.product-item' ).each( function () {
            var post_id = $( this ).attr( 'data-id' ).replace( 'post-', '' );
            _except_post_ids.push( post_id );
        } );
        // get post ID in array
        var _style_product  = $( '#content-' + _private_ID + ' .product-item' ).data( 'style' ),
            _number_product = $( '#content-' + _private_ID + ' .product-item' ).data( 'number' ),
            _class_product  = $( '#content-' + _private_ID + ' .product-item' ).attr( 'class' ),
            _width          = $( '#content-' + _private_ID + ' .product-item' ).data( 'width' ),
            _height         = $( '#content-' + _private_ID + ' .product-item' ).data( 'height' ),
            _cat            = $( '#content-' + _private_ID + ' .product-item' ).data( 'cat' ),
            data            = {
                action: 'maxstoreplus_loadmore_product',
                security: maxstoreplus_ajax_frontend.security,
                except_post_ids: _except_post_ids,
                style_product: _style_product,
                number_product: _number_product,
                class_product: _class_product,
                width: _width,
                height: _height,
                cat: _cat,
            };

        $( this ).html( '<i style="text-decoration: none" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>' );

        $.post( maxstoreplus_ajax_frontend.ajaxurl, data, function ( response ) {

            var items = $( '' + response['html'] + '' );

            if ( $.trim( response['success'] ) == 'ok' ) {

                $( '#content-' + _private_ID ).append( items );

            } else {
                $( '#content-' + _private_ID ).append( '<p class="return-message bg-success">Not ok</p>' );
            }

            $( '.ms-button-loadmore' ).html( 'load more items<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>' );

            if ( $( '#content-' + _private_ID ).find( '.owl-carousel' ).length ) {
                $( '#content-' + _private_ID ).find( '.owl-carousel' ).init_carousel();
            }
            if ( $( '#content-' + _private_ID ).find( '.lazy' ).length ) {
                $( '#content-' + _private_ID ).find( '.lazy' ).init_lazy_load();
            }
            resize_height();
        } );

        return false;
    } );

    /* ---------------------------------------------
     INSTANT SEARCH
     --------------------------------------------- */
    $( document ).on( 'click', '.header .search-bar .search-button', function () {
        $( 'body' ).addClass( 'ms-sidebar-mobile' );
        var _this = $( this );
        if ( !_this.hasClass( 'loaded' ) ) {
            var data        = {
                action: 'check_search',
                security: maxstoreplus_ajax_frontend.security,
            };
            var update_ajax = function ( response ) {
                var _array_search = response['array'];

                if ( $.trim( response['success'] ) == 'ok' ) {
                    $( document ).on( 'keyup', '.instant-search', function ( e ) {
                        var $this                      = $( this ),
                            searchWrap                 = $( '.search-content .result-search' ),
                            search_key                 = $.trim( $this.val() ),
                            max_instant_search_results = 12;

                        searchWrap.html( '' );

                        if ( _array_search && search_key != '' ) {
                            var search_results = maxstoreplus_search_json( search_key, _array_search );
                            if ( search_results ) {
                                searchWrap.append( '' );
                                for ( var i = 0; i < search_results.length && i < max_instant_search_results; i++ ) {
                                    searchWrap.append( search_results[i]['post_html'] );
                                }
                            }
                        }
                    } );
                }
            }

            _this.parent().find( '.search-content' ).addClass( 'loading' );
            $.ajax( {
                type: 'POST',
                url: maxstoreplus_ajax_frontend.ajaxurl,
                data: data,
                success: update_ajax,
                complete: function () {
                    _this.parent().find( '.search-content' ).removeClass( 'loading' );
                    _this.addClass( 'loaded' );
                },
                timeout: 10000
            } );
        }

        return false;
    } );


    function maxstoreplus_search_json( search_key, json_args ) {
        var all_results = Array();
        $.each( json_args, function ( i, v ) {
            var regex = new RegExp( search_key, "i" );
            if ( v.post_title.search( new RegExp( regex ) ) != -1 ) {
                all_results.push( v );
            }
        } );

        return all_results;
    }

    /* ---------------------------------------------
     Init popup
     --------------------------------------------- */
    function init_popup() {

        if ( maxstoreplus_global.kt_enable_popup_newsletter_mobile == '0' ) {
            if ( $( window ).width() + maxstoreplus_get_scrollbar_width() < 768 ) {
                return false;
            }
        }
        var disabled_popup_by_user = getCookie( 'kt_disabled_popup_by_user' );
        if ( disabled_popup_by_user == 'true' ) {

        } else {
            if ( $( 'body' ).hasClass( 'home' ) && maxstoreplus_global.kt_enable_popup_newsletter && maxstoreplus_global.kt_enable_popup_newsletter == '1' ) {
                setTimeout( function () {
                    $( '#popup-newsletter' ).modal( {
                        keyboard: false
                    } )
                }, maxstoreplus_global.kt_popup_delay_time );

            }
        }
    };

    function setCookie( cname, cvalue, exdays ) {
        var d = new Date();
        d.setTime( d.getTime() + (exdays * 24 * 60 * 60 * 1000) );
        var expires     = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    };

    function getCookie( cname ) {
        var name = cname + "=",
            ca   = document.cookie.split( ';' );
        for ( var i = 0; i < ca.length; i++ ) {
            var c = ca[i];
            while ( c.charAt( 0 ) == ' ' ) {
                c = c.substring( 1 );
            }
            if ( c.indexOf( name ) == 0 ) {
                return c.substring( name.length, c.length );
            }
        }
        return "";
    };

    $( document ).on( 'change', '.kt_disabled_popup_by_user', function () {
        if ( $( this ).is( ":checked" ) ) {
            setCookie( "kt_disabled_popup_by_user", 'true', 7 );
        } else {
            setCookie( "kt_disabled_popup_by_user", '', 0 );
        }
    } );

    function bxslider_init() {
        var settings = function () {
            var settings1 = {
                mode: 'horizontal',
                minSlides: 3,
                maxSlides: 3,
                slideMargin: 20,
                slideWidth: 200,
                pager: false,
                infiniteLoop: false,
                touchEnabled: false,
                nextText: '<span class="fa fa-angle-right"></span>',
                prevText: '<span class="fa fa-angle-left"></span>',
            };
            var settings2 = {
                mode: 'vertical',
                minSlides: 3,
                maxSlides: 3,
                slideMargin: 20,
                pager: false,
                infiniteLoop: false,
                touchEnabled: false,
                nextText: '<span class="fa fa-angle-down"></span>',
                prevText: '<span class="fa fa-angle-up"></span>',
            };
            return ($( window ).innerWidth() <= 1024) ? settings1 : settings2;
        }

        var mySlider;

        function tourLandingScript() {
            mySlider.reloadSlider( settings() );
        }

        mySlider = $( '.pr-gallery-vectical .cp-dots-custom' ).bxSlider( settings() );

        if ( $( '.bx-wrapper' ).length > 0 ) {
            $( window ).resize( tourLandingScript );
        }
    };

    /* ---------------------------------------------
     TAB EFFECT
     --------------------------------------------- */
    $.fn._animation_tabs = function ( _tab_animated ) {
        _tab_animated = (_tab_animated === undefined || _tab_animated === '') ? '' : _tab_animated;
        if ( _tab_animated !== '' ) {
            $( this ).find( '.product-list-owl .owl-item.active, .product-list-grid .product-item' ).each( function ( i ) {
                var _this  = $( this ),
                    _style = _this.attr( 'style' ),
                    _delay = i * 200;

                _style = (_style === undefined) ? '' : _style;
                _this.attr( 'style', _style +
                    ';-webkit-animation-delay:' + _delay + 'ms;' +
                    '-moz-animation-delay:' + _delay + 'ms;' +
                    '-o-animation-delay:' + _delay + 'ms;' +
                    'animation-delay:' + _delay + 'ms;'
                ).addClass( _tab_animated + ' animated' ).one( 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    _this.removeClass( _tab_animated + ' animated' );
                    _this.attr( 'style', _style );
                } );
            } );
        }
    };

    $.fn.init_lazy_load = function () {
        $( this ).each( function () {
            var _config = [];

            if ( $( this ).closest( '.menu-item, .flex-viewport, .widget_shopping_cart' ).length ) {
                _config.delay = 0;
            } else {
                _config.beforeLoad     = function ( element ) {
                    if ( element.is( 'div' ) === true ) {
                        element.addClass( 'loading-lazy' );
                    } else {
                        element.parent().addClass( 'loading-lazy' );
                    }
                };
                _config.afterLoad      = function ( element ) {
                    if ( element.is( 'div' ) === true ) {
                        element.removeClass( 'loading-lazy' );
                    } else {
                        element.parent().removeClass( 'loading-lazy' );
                    }
                };
                _config.effect         = "fadeIn";
                _config.enableThrottle = true;
                _config.throttle       = 250;
                _config.effectTime     = 600;
            }
            $( this ).lazy( _config );
        } );
    };

    function maxstoreplus_get_url_var( key, url ) {
        var result = new RegExp( key + "=([^&]*)", "i" ).exec( url );
        return result && result[1] || "";
    }

    /* TOGGLE MINI - CART*/
    $( document ).mouseup( function ( e ) {
        var container = $( '.shopcart-description' );
        $( document ).on( 'click', '.shopcart-icon', function () {
            $( this ).parent().find( '.shopcart-description' ).toggleClass( 'open' );
            return false;
        } );
        if ( !container.is( e.target ) // if the target of the click isn't the container...
            && container.has( e.target ).length === 0 ) // ... nor a descendant of the container
        {
            container.removeClass( 'open' );
        }
    } );

    /* ---------------------------------------------
     Ajax Tab
     --------------------------------------------- */
    $( document ).on( 'click', '.ms-tabs .tabs-link a', function ( e ) {
        e.preventDefault();
        var t          = $( this ),
            id         = t.data( 'id' ),
            tab_id     = t.attr( 'href' ),
            animate    = t.data( 'animate' ),
            tab_ajax   = t.data( 'ajax' ),
            section_id = t.data( 'section' );

        if ( tab_ajax == 1 && !$( this ).hasClass( 'loaded' ) ) {
            $( tab_id ).closest( '.tab-container' ).addClass( 'loading' );
            t.parent().addClass( 'active' ).siblings().removeClass( 'active' );
            $.ajax( {
                type: 'POST',
                url: maxstoreplus_ajax_frontend.ajaxurl,
                data: {
                    action: 'maxstoreplus_ajax_tabs',
                    security: maxstoreplus_ajax_frontend.security,
                    id: id,
                    section_id: section_id,
                },
                success: function ( response ) {
                    if ( response['success'] == 'ok' ) {
                        $( tab_id ).html( $( response['html'] ).find( '.vc_tta-panel-body' ).html() );
                        $( tab_id ).addClass( 'active' ).siblings().removeClass( 'active' );
                        $( tab_id ).closest( '.tab-container' ).removeClass( 'loading' );
                        t.addClass( 'loaded' );
                    }
                },
                complete: function () {
                    if ( $( tab_id ).find( '.owl-carousel' ).length ) {
                        $( tab_id ).find( '.owl-carousel' ).init_carousel();
                    }
                    if ( $( tab_id ).find( '.lazy' ).length ) {
                        $( tab_id ).find( '.lazy' ).init_lazy_load();
                    }
                    $( tab_id )._animation_tabs( animate );
                }
            } );
        } else {
            t.parent().addClass( 'active' ).siblings().removeClass( 'active' );
            $( tab_id ).addClass( 'active' ).siblings().removeClass( 'active' );
            $( tab_id )._animation_tabs( animate );
            if ( $( tab_id ).find( '.lazy' ).length ) {
                $( tab_id ).find( '.lazy' ).init_lazy_load();
            }
        }
    } );

    /* ---------------------------------------------
     Scripts initialization
     --------------------------------------------- */

    // after ajax call
    $( document ).ajaxComplete( function ( event, xhr ) {
        if ( xhr.status == 200 && xhr.responseText ) {
            if ( $( event.target ).find( '.lazy' ).length ) {
                $( event.target ).find( '.lazy' ).init_lazy_load();
            }
        }
    } );

    $( document ).on( 'qv_loader_stop', function ( event ) {
        if ( $( event.target ).find( '.owl-carousel' ).length ) {
            $( event.target ).find( '.owl-carousel' ).init_carousel();
        }
        if ( $( event.target ).find( '.pr-gallery-vectical' ).length ) {
            $( event.target ).find( '.pr-gallery-vectical .cp-dots-custom' ).bxSlider( {
                mode: 'vertical',
                minSlides: 3,
                maxSlides: 3,
                slideMargin: 20,
                pager: false,
                infiniteLoop: false,
                nextText: '<span class="fa fa-angle-down"></span>',
                prevText: '<span class="fa fa-angle-up"></span>',
            } );
        }
    } );


    $( document ).on( 'updated_wc_div', function ( event ) {
        if ( $( event.target ).find( '.owl-carousel' ).length > 0 ) {
            $( event.target ).find( '.owl-carousel' ).init_carousel();
        }
    } );

    /* ---------------------------------------------
     Scripts resize
     --------------------------------------------- */
    $( window ).resize( function () {
        if ( $( '.owl-carousel' ).length ) {
            $( '.owl-carousel' ).init_carousel();
        }
        height_full()
        resize_height();
        show_submenu();
    } );
    //BACK TO TOP
    $( 'a.backtotop' ).on( 'click', function () {
        $( 'html, body' ).animate( { scrollTop: 0 }, 800 );
        return false;
    } );

    /* ---------------------------------------------
     Scripts scroll
     --------------------------------------------- */
    $( window ).scroll( function () {
        cp_sticky();
        if ( $( window ).scrollTop() > 1 ) {
            $( '.backtotop' ).show( 500 );
        } else {
            $( '.backtotop' ).hide( 500 );
        }
    } );
    $( document ).ready( function () {
        append_mobile();
    } );
    window.addEventListener( "load", function load() {
        /**
         * remove listener, no longer needed
         * */
        window.removeEventListener( "load", load, false );
        /**
         * start functions
         * */
        if ( $( '.lazy' ).length ) {
            $( '.lazy' ).init_lazy_load();
        }
        if ( $( '.woocommerce-ordering' ).length ) {
            $( '.woocommerce-ordering .orderby' ).chosen( { disable_search_threshold: 10 } );
        }
        if ( $( '.categori-search-option' ).length ) {
            $( '.categori-search-option' ).chosen();
        }
        if ( $( '.owl-carousel' ).length ) {
            $( '.owl-carousel' ).init_carousel();
        }
        countdown();
        init_popup();
        height_full();
        parallaxInit();
        show_submenu();
        resize_height();
        dropdown_menu();
    }, false );

})( window.jQuery );