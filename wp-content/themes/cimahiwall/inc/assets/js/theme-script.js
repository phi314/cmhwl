jQuery( function ( $ ) {
    'use strict';
    // here for each comment reply link of wordpress
    $( '.comment-reply-link' ).addClass( 'btn btn-link' );

    // here for the submit button of the comment reply form
    $( '#commentsubmit' ).addClass( 'btn btn-common' );

    // The WordPress Default Widgets
    // Now we'll add some classes for the wordpress default widgets - let's go

    // the search widget
    $( '.widget_search input.search-field' ).addClass( 'form-control' );
    $( '.widget_search input.search-submit' ).addClass( 'btn btn-default' );
    $( '.variations_form .variations .value > select' ).addClass( 'form-control' );
    $( '.widget_rss ul' ).addClass( 'media-list' );

    $( '.widget_meta ul, .widget_recent_entries ul, .widget_archive ul, .widget_categories ul, .widget_nav_menu ul, .widget_pages ul, .widget_product_categories ul' ).addClass( 'nav flex-column' );
    $( '.widget_meta ul li, .widget_recent_entries ul li, .widget_archive ul li, .widget_categories ul li, .widget_nav_menu ul li, .widget_pages ul li, .widget_product_categories ul li' ).addClass( 'nav-item' );
    $( '.widget_meta ul li a, .widget_recent_entries ul li a, .widget_archive ul li a, .widget_categories ul li a, .widget_nav_menu ul li a, .widget_pages ul li a, .widget_product_categories ul li a' ).addClass( 'nav-link' );

    $( '.widget_recent_comments ul#recentcomments' ).css( 'list-style', 'none').css( 'padding-left', '0' );
    $( '.widget_recent_comments ul#recentcomments li' ).css( 'padding', '5px 15px');

    $( 'table#wp-calendar' ).addClass( 'table table-striped');

    // Adding Class to contact form 7 form
    $('.wpcf7-form-control').not(".wpcf7-submit, .wpcf7-acceptance, .wpcf7-file, .wpcf7-radio").addClass('form-control');
    $('.wpcf7-submit').addClass('btn btn-primary');

    // Adding Class to Woocommerce form
    $('.woocommerce-Input--text, .woocommerce-Input--email, .woocommerce-Input--password').addClass('form-control');
    $('.woocommerce-Button.button').addClass('btn btn-primary mt-2').removeClass('button');

    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).parent().siblings().removeClass('open');
        $(this).parent().toggleClass('open');
    });

    // Add Option to add Fullwidth Section
    function fullWidthSection(){
        var screenWidth = $(window).width();
        if ($('.entry-content').length) {
            var leftoffset = $('.entry-content').offset().left;
        }else{
            var leftoffset = 0;
        }
        $('.full-bleed-section').css({
            'position': 'relative',
            'left': '-'+leftoffset+'px',
            'box-sizing': 'border-box',
            'width': screenWidth,
        });
    }
    fullWidthSection();
    $( window ).resize(function() {
        fullWidthSection();
    });

    // Allow smooth scroll
    $('.page-scroller').on('click', function (e) {
        e.preventDefault();
        var target = this.hash;
        var $target = $(target);
        $('html, body').animate({
            'scrollTop': $target.offset().top
        }, 1000, 'swing');
    });

    /**
     * Customy
     */

    // Bootstrap tab using url
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    }
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });

    // Slick
    if( $.fn.slick ) {
        var $slickOnMobile = $('.slick-mobile-gallery');
        $slickOnMobile.slick({
            mobileFirst: true,
            responsive: [
                {
                    breakpoint: 480,
                    settings: "unslick"
                }
            ]
        });

        $('.full-screen-slider .row').slick({
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            autoplay: true,
            autoplaySpeed: 4000,
            nextArrow: $('.featured-listing-next-btn'),
            prevArrow: $('.featured-listing-prev-btn'),
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        centerMode: false
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: false,
                        centerMode: false
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false,
                        centerMode: false
                    }
                }
            ]
        });
        $('#latest-culinary-listing .card-list').slick({
            centerMode: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            nextArrow: $('.latest-culinary-listing-next-btn'),
            prevArrow: $('.latest-culinary-listing-prev-btn')
        });

        var $top_slider = $('.top-slider');
        $top_slider.slick({
            dots: true,
            arrows: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            variableWidth: true
        });
    }

    // bootstrap tooltip
    if( $.fn.tooltip ) {
        $('[data-toggle="tooltip"]').tooltip()
    }

    // Timer
    if( $.fn.countTo ) {

        $('.timer').countTo({
            refreshInterval: 60,
            formatter: function (value, options) {
                return value.toFixed(options.decimals);
            }
        });

    }

    // Reset search form
    $('.btn-reset-search').on('click', function(e){
        e.preventDefault();
        $('.advanced-search input[name=s]').val('');
        $('.advanced-search select:lt(3)').val('').trigger('change');
    });

    // select2
    $(document).ready(function() {
        if( $.fn.select2 ) {
            $('.select2').select2();
            $('.select2 .select2-selection--single').addClass('form-control');
        }
    });

    // Acf Map
    (function($) {
        var infoWindows = [];
        $(document).ready(function() {
            function new_map($el, $classContainer) {

                var mapStyle = [
                    {
                        "featureType": "administrative",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#444444"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#f2f2f2"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "all",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 45
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#b4d4e1"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    }
                ];
                var $markers = $($classContainer).find('.marker');
                var args = {
                    zoom: 16,
                    center: {lat: -6.8862572, lng: 107.523612},
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: mapStyle,
                    gestureHandling: 'cooperative'
                };
                var map = new google.maps.Map($el[0], args);
                map.markers = [];
                $markers.each(function () {
                    add_marker($(this), map);
                });

                center_map(map);

                var markerCluster = new MarkerClusterer(map, map.markers, {
                    imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',
                    maxZoom: 16
                });

                return map;

            }

            function add_marker($marker, map) {

                if (( $marker.attr('data-lat') != '' ) && ($marker.attr('data-lng') != '' )) {
                    var markerIcon = {
                        path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
                        fillColor: '#ff4d55',
                        fillOpacity: 0.95,
                        scale: 1.5,
                        strokeColor: '#fff',
                        strokeWeight: 1,
                        anchor: new google.maps.Point(12, 24)
                    };
                    var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
                    var marker = new google.maps.Marker({
                        position: latlng,
                        icon: markerIcon,
                        map: map
                    });

                    map.markers.push(marker);
                    if ($marker.html()) {
                        var title = $marker.find('.card-title');
                        var permalink = $marker.find('.place-permalink');
                        // var image = $marker.find('.')
                        var image = $marker.find('.image').data('image-url');
                        var infowindow = new google.maps.InfoWindow({
                            content: '<div class="infowindow text-center"><h3><a href="' + permalink.text() + '">' + title.text() + '</a></h3>' +
                            '<br>' +
                            '<a href="' + permalink.text() + '"><img src="'+ image +'"></a>' +
                            '</div>'
                        });

                        infoWindows.push(infowindow);

                        // show info window when marker is clicked & close other markers
                        google.maps.event.addListener(marker, 'click', function () {
                            map.setCenter(latlng);
                            //close all
                            for (var i = 0; i < infoWindows.length; i++) {
                                infoWindows[i].close();
                            }
                            //swap content of that singular infowindow
                            infowindow.open(map, marker);
                        });
                        // close info window when map is clicked
                        google.maps.event.addListener(map, 'click', function (event) {
                            if (infowindow) {
                                infowindow.close();
                            }
                        });
                    }
                }
            }

            function center_map(map) {
                var bounds = new google.maps.LatLngBounds();
                $.each(map.markers, function (i, marker) {
                    var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
                    bounds.extend(latlng);
                });
                if( map.markers.length > 0 ) {

                    if (map.markers.length == 1) {
                        map.setCenter(bounds.getCenter());
                        map.setZoom(15);
                    }
                    else {
                        map.fitBounds(bounds);
                    }
                }
                else {
                    var latlng = new google.maps.LatLng(-6.8862572, 107.523612);
                    bounds.extend(latlng);
                    map.setCenter(bounds.getCenter());
                    map.setZoom(10);
                }
            }

            var map = null;
            $(document).ready(function () {

                // Archive, Search Place
                $('#top-map').each(function () {
                    map = new_map($(this), '.list-places');
                });

                // Single Place
                $('#place-map').each(function () {
                    map = new_map($(this), '.location');
                });

            });
        });
    })(jQuery);

    // on view port function
    $.fn.isInViewport = function() {

        var elementTop = '';
        if( $(this).length )
            elementTop = $(this).offset().top;

        var elementBottom = elementTop + $(this).outerHeight();

        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();

        return elementBottom > viewportTop && elementTop < viewportBottom;
    };

    // Animate on viewport
    $(window).scroll(function(){
       if( $('#spotlight').isInViewport() ) $('#spotlight').addClass('animated bounceInUp');
       if( $('#spotlight-recent').isInViewport() ) $('#spotlight-recent').addClass('animated bounceInUp');
    });

    // Rating
    // (function($){
    //     $('#cimahiwall-rate').barrating({
    //         theme: 'fontawesome-stars',
    //         allowEmpty: null
    //     });
    //     $('.cimahiwall_rating_only').barrating({
    //         theme: 'fontawesome-stars',
    //         readonly: true
    //     });
    //
    //     $('.comment-reply-link').on('click', function(){
    //         $('#cimahiwall-rating-container').hide();
    //     });
    //     $('#cancel-comment-reply-link').on('click', function(){
    //         $('#cimahiwall-rating-container').show();
    //     });
    //
    // })(jQuery);

    // Jquery lazy Load
    (function($){
        if( $.fn.lazy ) {

            $('.lazy').lazy({
                effect: "fadeIn",
                effectTime: 1000
            });
        }

    })(jQuery);

    // Get current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(savePosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
    
    function savePosition( position ) {
        document.cookie='userLat='+position.coords.latitude;
        document.cookie='userLng='+position.coords.longitude; 
    }

    $(".btn-near-me").on('click', function(){
        var loc = location.href;       
        loc += loc.indexOf("?") === -1 ? "?" : "&";
    
        location.href = loc + "nearme=true";
    });

    /**
     * ===========================================
     *  AJAX
     */

    // Showing area by city on select
    var $selectCity = $('select[name=city]');
    var $selectArea = $('select[name=area]');
    var selectedArea = $selectArea.data('selected-area');
    $selectCity.on('change', function(e) {
        var cityId = $(this).find(':selected').data('city-id');
        if( cityId != '') {
            $.getJSON(cimahiwall.ajax_url + "?action=get_area_by_city&cityId=" + cityId, function (data) {
                if (data.length > 0) {
                    var $selectArea = $('select[name=area]');
                    $selectArea.html('<option value="">- Pilih Area -</option>'); // emptying area first
                    $.each(data, function (index, value) {
                        $selectArea.append(new Option(value.name, value.slug));
                    });
                    // Set selected area
                    $selectArea.val(selectedArea);
                }
            });
        }
        else {
            $selectArea.html('<option value="">- Pilih Area -</option>'); // emptying area first
        }
    });
    $selectCity.trigger('change'); // trigger on load

    // Remove comment ajax
    $('.btn-remove-comment').on('click', function(e) {
        e.preventDefault();
       var comment_id = $(this).data('comment-id');
       $.ajax({
            type: 'POST',
            url: cimahiwall.ajax_url,
            data: {
               comment_id: comment_id, action: 'delete_comment'
            },
            beforeSend: function() {
               var $comment = $('#comment-' + comment_id);
               $comment.hide('slow', function () {
                   $comment.remove();
               });
            }
       });
    });

});
