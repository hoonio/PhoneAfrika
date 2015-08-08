// Whole-script strict mode syntax
"use strict";
(function ($) {
    $(function () {
        //Toggle the Accordion Icons
        $('.accordion-group').on('show', function () {
            var $icon = $(this).find('.accordion-toggle-icon');
            $icon.removeClass('entypo-plus-squared');
            $icon.addClass('entypo-minus-squared');

            $(this).find('.accordion-toggle').removeClass('collapsed');
        });
        $('.accordion-group').on('hide', function () {
            var $icon = $(this).find('.accordion-toggle-icon');
            $icon.addClass('entypo-plus-squared');
            $icon.removeClass('entypo-minus-squared');

            $(this).find('.accordion-toggle').addClass('collapsed');
        });

        // Disable certain links in docs
        $('body [href^=#]').click(function (e) {
            e.preventDefault()
        });

        if ($().countTo && $().waypoint) {
//            $('.count-span').countTo();
            $('.count-box').waypoint(function (direction) {
                $(this).find('.count-inner').countTo();
            }, { triggerOnce: true, offset: '100%'});
        }

        if (window['Donut'] != undefined) {

            $('.animated-circle').each(
                function () {
                    var $this = $(this);
                    var options = {
                        lines: 12,
                        angle: 0.5,
                        lineWidth: 0.05,
                        colorStart: $this.data('track-color'),
                        colorStop: $this.data('bar-color'),
                        strokeColor: $this.data('track-color'),
                        generateGradient: false
                    };
                    var gauge = new Donut(this).setOptions(options);
                    gauge.maxValue = 100;
                    gauge.animationSpeed = 128;
                    gauge.set($this.data('value'));
                }
            );
        }

        //Make the first tab in a tabs display.
        var $activeTabPanes = $('.tab-shortcode .tab-pane.active');

        //set the explicitly 'active' tabs to show
        _.each($activeTabPanes, function (tp) {
            var $tp = $(tp);
            var $tab = $('.tabs a[href="#' + $tp.attr('id') + '"]');
            $tab.tab('show');
        });

        var $tabsc = $('.tab-shortcode');
        _.each($tabsc, function (tsc) {
            var $tsc = $(tsc);
            if ($tsc.find('.tab-pane.active').length == 0) {
                $tsc.find('.tabs .tab-shortcode-tab:first').tab('show');
            }
        });


        //Tooltip and Popover are manual opt-in, so we
        //kick off the tooltip and popover
        $('body').tooltip({
            selector: "a[data-toggle=tooltip]"
        });
//        $("a[data-toggle=tooltip]").tooltip('show');

        $("a[data-toggle=popover]")
            .popover()
            .click(function (e) {
                e.preventDefault()
            });

        //Set the first slide active
        $('.carousel.slide .carousel-inner > .item:first-child').addClass('active');
        $('.carousel.slide .carousel-indicators > li:first-child').addClass('active');
        //TBS carousel doesn't pick up data-interval right now, so we grab it
        //and plug it into the 'carousel' method.
        $('.carousel').each(function () {
            var car = $(this);
            var interval = car.attr('data-interval');
            if (interval == 'false') interval = false;
            car.carousel({interval: interval});
        });

        if ($().adapPortfolio) {

            //for any portfolio items that don't have an img
            //go ahead and show them
            $('.adap-portfolio .portfolio-item').each(function () {
                if ($(this).find('img').length == 0) {
                    $(this).find('.image-wrapper').removeClass('invisible');
                }
            });
            //track the image loading and remove the "invisible" class
            //from portfolio items once their images are loaded.
            $.adap_sc_util.imageLoadTracker({
                container: '.adap-portfolio',
                onImageLoaded: function ($img) {
                    $img.closest('.portfolio-item').find('.image-wrapper').removeClass('invisible').addClass('image-loaded');
                },
                onAllLoaded: function () {
                    $('.adap-portfolio .portfolio-item .image-wrapper').removeClass('invisible').addClass('image-loaded');
                    $(window).trigger('resize');
                }

            });
            $('.adap-portfolio').adapPortfolio({});


        }

        if ($().prettyPhoto) {

            //Call prettyPhoto in case there isn't already a call to it.
            try {
                if (Modernizr.mq('only screen and (max-width: 479px)')) {
                    jQuery('.prettyPhoto').unbind('click');
                    window['vc_prettyPhoto'] = function () {
                    };
                } else {

                    // just in case. maybe prettyphoto isnt loaded on this site
                    jQuery('a[href *= "vimeo.com"], a[href *= "youtube.com"], a[href *= "http://youtu.be"]', 'a[href$=jpg], a[href$=png], a[href$=gif], a[href$=jpeg], a[href$=".mov"] , a[href$=".swf"] , a[href*="screenr.com"]').prettyPhoto({
                        animationSpeed: 'normal', /* fast/slow/normal */
                        padding: 15, /* padding for each side of the picture */
                        opacity: 0.7, /* Value betwee 0 and 1 */
                        showTitle: true, /* true/false */
                        allowresize: true, /* true/false */
                        counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
                        //theme: 'light_square', /* light_rounded / dark_rounded / light_square / dark_square */
                        hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
                        modal: false, /* If set to true, only the close button will close the window */
                        callback: function () {
                            var url = location.href;
                            var hashtag = (url.indexOf('#!prettyPhoto')) ? true : false;
                            if (hashtag) location.hash = "!";
                        } /* Called when prettyPhoto is closed */,
                        social_tools: ''
                    });
                }
            } catch (err) {
            }

        }

        if ($().elastislide) {

            jQuery('.clients-carousel-list').each(function () {
//                var minItems = list.attr('data-minItems');
//                jQuery(this).find('img').css('height', 'auto');

                jQuery(this).elastislide({
                    minItems: 4
                });
            });
        }

        if ($().textfill) {
            $(window).on("debouncedresize",function () {
                $('.animated-circle-label').textfill();
            }).trigger('debouncedresize');
            $('.animated-circle-intro').textfill(12);

        }


        $(window).on("debouncedresize",function () {

            $('.animated-circle-wrapper').each(function () {

                var circle = $('canvas.animated-circle', this);
                var width = $(this).width();
                circle.width(width);
                circle.height(width);
            });

        }).trigger('debouncedresize');


    });
})(jQuery);

/** Preloader logic **/
(function ($) {
    $.adap_sc_util = $.adap_sc_util || {};
    $.adap_sc_util.imageLoadTracker = function (options) {
        var $window = $(window);

        var default_options = {
            exitAfter: 15,
            container: 'body',
            onAllLoaded: function () {
            },
            onImageLoaded: function () {
            }
        }
        options = $.extend({}, default_options, options);
            var functions = {
                pollImages: function ($container) {

                    $container.find('img').each(function () {

                        var theImage = this;

                        if (theImage.complete === true) {
//                        console.log('Image Loaded:');
                            //remove teh image from the lise
                            $container.imgs = $container.imgs.not(theImage);
                            //decrement the image count
                            $container.imgCount -= 1;
                            options.onImageLoaded($(theImage));
                            $window.trigger('adap_sc_preload_complete');
                        }
                        else if ($container.imgCount && options.exitAfter >= 0) {
                            options.exitAfter -= 1;
                            setTimeout(function () {
                                functions.pollImages($container);
                            }, 600);
                        }


                        if ($container.imgCount == 0 || options.exitAfter == 0) {
                            options.onAllLoaded();
                        }
                    });


                }
            };

        var $container = $(options.container);

        $container.each(function () {
            var $cont = $(this);
            $cont.imgs = $cont.find('img');

            $cont.imgCount = $cont.imgs.length;
            setTimeout(function () {
                functions.pollImages($cont);
            }, 12);

        });

    }

})(jQuery);

// Plugin to resize text to fill its container
// https://gist.github.com/mekwall/1263939
(function ($) {
    $.fn.textfill = function (maxFontSize) {
        maxFontSize = parseInt(maxFontSize, 10);
        return this.each(function () {
            var ourText = $("span", this),
                parent = ourText.parent(),
                maxHeight = parent.height(),
                maxWidth = parent.width(),
                fontSize = parseInt(ourText.css("fontSize"), 10),
                multiplier = maxWidth / ourText.width(),
                newSize = (fontSize * (multiplier - 0.1));
            ourText.css(
                "fontSize",
                (maxFontSize > 0 && newSize > maxFontSize) ?
                    maxFontSize :
                    newSize
            );
        });
    };
})(jQuery);

/*
 * debouncedresize: special jQuery event that happens once after a window resize
 *
 * latest version and complete README available on Github:
 * https://github.com/louisremi/jquery-smartresize
 *
 * Copyright 2012 @louis_remi
 * Licensed under the MIT license.
 *
 * This saved you an hour of work?
 * Send me music http://www.amazon.co.uk/wishlist/HNTU0468LQON
 */
(function ($) {

    var $event = $.event,
        $special,
        resizeTimeout;

    $special = $event.special.debouncedresize = {
        setup: function () {
            $(this).on("resize", $special.handler);
        },
        teardown: function () {
            $(this).off("resize", $special.handler);
        },
        handler: function (event, execAsap) {
            // Save the context
            var context = this,
                args = arguments,
                dispatch = function () {
                    // set correct event type
                    event.type = "debouncedresize";
                    $event.dispatch.apply(context, args);
                };

            if (resizeTimeout) {
                clearTimeout(resizeTimeout);
            }

            execAsap ?
                dispatch() :
                resizeTimeout = setTimeout(dispatch, $special.threshold);
        },
        threshold: 150
    };

})(jQuery);