//Calls waypoints when a tab gets navigated to
function adap_handle_progressive_color_in_tab(container) {
    _.defer(function () {
        container.find('.of-progressive-color').waypoint({

                handler: function () {
                    var el = jQuery(this);


                    _.defer(function () {
                        el.wpColorPicker();
                    });

                },
                offset: 'bottom-in-view',


                triggerOnce: true


            }
        );
    });
}
jQuery(document).ready(function () {

//    jQuery('#example_showhidden').click(function () {
//        jQuery('#section-example_text_hidden').fadeToggle(400);
//    });
//
//    if (jQuery('#example_showhidden:checked').val() !== undefined) {
//        jQuery('#section-example_text_hidden').show();
//    }

    /*
     * Only show translucent sticky header option if sticky header is enabled
     */
    jQuery('input#enable_sticky_header').on('change',function () {

        if (jQuery(this).prop('checked')) {
            jQuery('#section-enable_translucent_sticky_header').show();

        } else {
            jQuery('#section-enable_translucent_sticky_header').hide();
        }

    }).trigger('change');


    /*
     * Only show the site background image field if "Boxed Layout" is selected
     */

    if (jQuery('#stretched_or_boxed').val() == 'boxed') {
        jQuery('#section-site_background').show();
        jQuery('#section-enable_page_shadow').show();
        jQuery('#section-enable_cover_background').show();
    } else {
        jQuery('#section-site_background').hide();
        jQuery('#section-enable_page_shadow').hide();
        jQuery('#section-enable_cover_background').hide();
    }

    jQuery('#stretched_or_boxed').change(function () {
        jQuery('#section-site_background').fadeToggle(400);
        jQuery('#section-enable_page_shadow').fadeToggle(400);
        jQuery('#section-enable_cover_background').fadeToggle(400);
    });


    var active_tab = '';
    if (typeof(localStorage) != 'undefined') {
        active_tab = localStorage.getItem("active_tab");
    }

    if (active_tab != '' && jQuery(active_tab).length) {
        var container = jQuery(active_tab);
        adap_handle_progressive_color_in_tab(container);
    }

    jQuery('.nav-tab-wrapper a').on('click', function () {
        jQuery('.of-progressive-color').waypoint('destroy');
        var container = jQuery(jQuery(this).attr('href'));
        adap_handle_progressive_color_in_tab(container);

    });


    /*
     * Handle skin selection and color options
     */
    var $skin_select = jQuery('select#base_color_scheme');
    var selected_skin = $skin_select.val();
    var skin_colors = adap_theme_skins[selected_skin];

// Set all the color options on initial load if they are empty.
    for (var skin_color_option in skin_colors) {
        if (skin_colors.hasOwnProperty(skin_color_option)) {

            var $color_input = jQuery('input#' + skin_color_option);
            if (!$color_input.val()) {
                $color_input.val(skin_colors[skin_color_option]);
            }

        }
    }

// When the skin selector value changes, update all the color options
    $skin_select.on('change', function () {
        selected_skin = $skin_select.val();
        skin_colors = adap_theme_skins[selected_skin];

        for (var skin_color_option in skin_colors) {
            if (skin_colors.hasOwnProperty(skin_color_option)) {

                var $color_input = jQuery('input#' + skin_color_option);
                var skin_color = skin_colors[skin_color_option];
                $color_input.val(skin_color);
                // Force the iris color picker to update
                $color_input.trigger('change');
            }
        }
    });


    /*
     * Social Icon Selection
     */
    jQuery("select[id^='social_icon_']").on('change',function () {

        var social_icon_num = jQuery(this).attr('id').slice(-1);

        // Hide URL field if "None" or "Email" is selected
        var $matching_url_section = jQuery('div#section-social_icon_url_' + social_icon_num);
        if (jQuery(this).val() == 'none' || jQuery(this).val() == 'email') {
            $matching_url_section.hide();
        } else {
            $matching_url_section.show();
        }

        // Show the Phone Number field if "Phone" is selected
        var $matching_phonenumber_section = jQuery('div#section-social_icon_phonenumber_' + social_icon_num);
        if (jQuery(this).val() == 'phone') {
            $matching_phonenumber_section.show();
        } else {
            $matching_phonenumber_section.hide();
        }

        // Show the Email Address field if "Email" is selected
        var $matching_emailaddress_section = jQuery('div#section-social_icon_emailaddress_' + social_icon_num);
        if (jQuery(this).val() == 'email') {
            $matching_emailaddress_section.show();
        } else {
            $matching_emailaddress_section.hide();
        }

    }).trigger('change');


    /*
     * Subfooter Social Icon Selection
     */
    jQuery("select[id^='subfooter_social_icon_']").on('change',function () {

        var social_icon_num = jQuery(this).attr('id').slice(-1);

        // Hide URL field if "None" or "Email" is selected
        var $matching_url_section = jQuery('div#section-subfooter_social_icon_url_' + social_icon_num);
        if (jQuery(this).val() == 'none') {
            $matching_url_section.hide();
        } else {
            $matching_url_section.show();
        }

    }).trigger('change');

})
;































