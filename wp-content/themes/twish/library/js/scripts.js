/*
 Bones Scripts File
 Author: Eddie Machado

 This file should contain any js scripts you want to add to the site.
 Instead of calling it in the header or throwing it inside wp_head()
 this file will be called automatically in the footer so as not to
 slow the page load.

 */

// Whole-script strict mode syntax
"use strict";

// IE8 ployfill for GetComputed Style (for Responsive Script below)
if (!window.getComputedStyle) {
    window.getComputedStyle = function (el, pseudo) {
        this.el = el;
        this.getPropertyValue = function (prop) {
            var re = /(\-([a-z]){1})/g;
            if (prop == 'float') prop = 'styleFloat';
            if (re.test(prop)) {
                prop = prop.replace(re, function () {
                    return arguments[2].toUpperCase();
                });
            }
            return el.currentStyle[prop] ? el.currentStyle[prop] : null;
        }
        return this;
    }
}

// as the page loads, call these scripts
jQuery(document).ready(function ($) {

    $('body').fitVids();

    $('input, textarea').placeholder();

    /*
     Responsive jQuery is a tricky thing.
     There's a bunch of different ways to handle
     it, so be sure to research and find the one
     that works for you best.
     */

    /* getting viewport width */
    var responsive_viewport = $(window).width();

    /* if is below 481px */
    if (responsive_viewport < 481) {

    }
    /* end smallest screen */

    /* if is larger than 481px */
    if (responsive_viewport > 481) {

    }
    /* end larger than 481px */

    /* if is above or equal to 768px */
    if (responsive_viewport >= 768) {

        /* load gravatars */
        $('.comment img[data-gravatar]').each(function () {
            $(this).attr('src', $(this).attr('data-gravatar'));
        });

    }

    /* off the bat large screen actions */
    if (responsive_viewport > 979) {

    }


    // ADD CUSTOM SCRIPTS HERE

    /* Handle empty <p> elements in IE8 */
    $('.lt-ie9 p:empty').addClass('empty-element');

    /* Remove the crummy pseudo-placeholder behavior on the Jetpack Subscribe widget */
    $('.jetpack_subscription_widget input#subscribe-field').removeAttr('onblur').removeAttr('onclick').val('').attr('placeholder', 'Email Address');

    /* Browser Detection */
    function setupBrowserCheck() {
        //if IE touch support
        var $html = jQuery('html');
        if ($html.hasClass('no-touch') &&
            jQuery.browser.msie &&
            ('onmsgesturechange' in window)) {
            $html.removeClass('no-touch');
            $html.addClass('touch');
        }

        var os = (function () {
            var ua = navigator.userAgent.toLowerCase();
            return {
                isWin2K: /windows nt 5.0/.test(ua),
                isXP: /windows nt 5.1/.test(ua),
                isVista: /windows nt 6.0/.test(ua),
                isWin7: /windows nt 6.1/.test(ua),
                isMac: /macintosh/.test(ua)
            };
        }());

        if (jQuery.browser.mozilla) jQuery('html').addClass('mozilla');
        if (jQuery.browser.msie) {
            jQuery('html').addClass('msie');
            if (jQuery.browser.version == '8.0') {
                jQuery('html').addClass('ie8');
            } else if (jQuery.browser.version == '9.0') {
                jQuery('html').addClass('ie9');
            } else if (jQuery.browser.version == '10.0') {
                jQuery('html').addClass('ie10');
            }
        }
        if (jQuery.browser.webkit) jQuery('html').addClass('webkit');
        if (os.isWin7 || os.isVista || os.isXP || os.isWin2K) {
            jQuery('html').addClass('ms-windows');
        } else if (os.isMac) {
            jQuery('html').addClass('macintosh');
        }

        // Code to differentiate between Safari and Chrome
        var userAgent = navigator.userAgent.toLowerCase();
        jQuery.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());
        // Is this a version of Chrome?
        if (jQuery.browser.chrome) {
            userAgent = userAgent.substring(userAgent.indexOf('chrome/') + 7);
            userAgent = userAgent.substring(0, userAgent.indexOf('.'));
            jQuery.browser.version = userAgent;
            // If it is chrome then jQuery thinks it's safari so we have to tell it it isn't
            jQuery.browser.safari = false;
            jQuery('html').addClass('chrome');
        }
        // Is this a version of Safari?
        if (jQuery.browser.safari) {
            userAgent = userAgent.substring(userAgent.indexOf('safari/') + 7);
            userAgent = userAgent.substring(0, userAgent.indexOf('.'));
            jQuery.browser.version = userAgent;
            jQuery('html').addClass('safari');
        }
        // Check for Mobile Safari
        userAgent = window.navigator.userAgent;
        if (userAgent.match(/iPad/i) || userAgent.match(/iPhone/i)) {
            jQuery('html').addClass('mobile-safari');
        }
        if (userAgent.match(/iPad/i)) {
            jQuery('html').addClass('ipad-client');
        }
        if (userAgent.match(/iPhone/i) || userAgent.match(/iPod/i)) {
            jQuery('html').addClass('iphone-client');
        }
        if (userAgent.match(/Android/i)) {
            jQuery('html').addClass('android-client');
        }

    }

    setupBrowserCheck();

    /* Sticky Header */

    if (!$('html').hasClass('ipad-client') && !$('html').hasClass('iphone-client') && !$('html').hasClass('android-client')) {
        if ($('body').hasClass('enable-sticky-header')) {
            $(window).scroll(function () {
                resizeStickyHeader();
            });
            $(window).on('debouncedresize', function () {
                resizeStickyHeader();
            });
        }
    }

});
/* end of as page load scripts */


/* A function for resizing the sticky header */
var adap_header_height = 108;
var adap_header_min_height = 50;

function resizeStickyHeader() {

    /* check scroll position */
    var scrollPos = jQuery(window).scrollTop();

    /* getting viewport width */
    var responsive_viewport = jQuery(window).width();

    // Proportionately resize header if fullsize
    if (responsive_viewport > 979) {

        // How tall we want the header to be
        var targetHeight = adap_header_height - scrollPos > adap_header_min_height ? adap_header_height - scrollPos : adap_header_min_height;

        // How far to proceed to mobile size settings
        var ratioReduce = (adap_header_height - targetHeight) / (adap_header_height - adap_header_min_height);

        // Set the line-height of top-level menu items and social icons since they determine the height of the header
        jQuery('.header-social-icon-list > li > a, .navbar .nav > li > a').css('height', targetHeight + 'px').css('line-height', targetHeight + 'px');

        // Handle logo
        var $logo = jQuery('body > .navbar .brand');

        // Set the voffset of the logo
        var voffsetFullsize = $logo.attr('data-fullsize-voffset');
        var voffsetMobile = $logo.attr('data-mobile-voffset');
        var voffsetDelta = voffsetFullsize - voffsetMobile;
        var voffsetNew = voffsetFullsize - voffsetDelta * ratioReduce;
        $logo.css('margin-top', voffsetNew + 'px');

        // Calculate width of the logo
        var widthFullsize = $logo.attr('data-fullsize-width');
        var widthMobile = $logo.attr('data-mobile-width');
        var widthDelta = widthFullsize - widthMobile;
        var widthNew = widthFullsize - widthDelta * ratioReduce;

        // Calculate height of the logo
        var heightFullsize = $logo.attr('data-fullsize-height');
        var heightMobile = $logo.attr('data-mobile-height');
        var heightDelta = heightFullsize - heightMobile;
        var heightNew = heightFullsize - heightDelta * ratioReduce;

        // Set height and width on both the logo link and logo img
        jQuery('body > .navbar .brand, body > .navbar .brand img').css('height', heightNew + 'px').css('width', widthNew + 'px');

    } else {

        // Clear the inline CSS for mobile
        jQuery('body > .navbar .brand').attr('style', '');
        jQuery('.header-social-icon-list > li > a, .navbar .nav > li > a').attr('style', '');

    }

    // Add some convenience classes
    var $headerNav = jQuery('.header-navbar');
    if (ratioReduce == 1) {
        $headerNav.addClass('sticky-header-small');
        $headerNav.removeClass('sticky-header-big');
        $headerNav.removeClass('sticky-header-resizing');
    }
    else if (ratioReduce == 0) {
        $headerNav.addClass('sticky-header-big');
        $headerNav.removeClass('sticky-header-small');
        $headerNav.removeClass('sticky-header-resizing');
    }
    else {
        $headerNav.addClass('sticky-header-resizing');
        $headerNav.removeClass('sticky-header-small');
        $headerNav.removeClass('sticky-header-big');
    }


}


/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
 */
(function (w) {
    // This fix addresses an iOS bug, so return early if the UA claims it's something else.
    if (!( /iPhone|iPad|iPod/.test(navigator.platform) && navigator.userAgent.indexOf("AppleWebKit") > -1 )) {
        return;
    }
    var doc = w.document;
    if (!doc.querySelector) {
        return;
    }
    var meta = doc.querySelector("meta[name=viewport]"),
        initialContent = meta && meta.getAttribute("content"),
        disabledZoom = initialContent + ",maximum-scale=1",
        enabledZoom = initialContent + ",maximum-scale=10",
        enabled = true,
        x, y, z, aig;
    if (!meta) {
        return;
    }
    function restoreZoom() {
        meta.setAttribute("content", enabledZoom);
        enabled = true;
    }

    function disableZoom() {
        meta.setAttribute("content", disabledZoom);
        enabled = false;
    }

    function checkTilt(e) {
        aig = e.accelerationIncludingGravity;
        x = Math.abs(aig.x);
        y = Math.abs(aig.y);
        z = Math.abs(aig.z);
        // If portrait orientation and in one of the danger zones
        if (!w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) )) {
            if (enabled) {
                disableZoom();
            }
        }
        else if (!enabled) {
            restoreZoom();
        }
    }

    w.addEventListener("orientationchange", restoreZoom, false);
    w.addEventListener("devicemotion", checkTilt, false);
})(this);