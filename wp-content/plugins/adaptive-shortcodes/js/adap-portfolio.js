// Whole-script strict mode syntax
"use strict";
(function ($) {
    //Create jQuery plugin for the Isotope behavior
    $.fn.adapPortfolio = function (options) {
        return this.each(function () {
            var $el = $(this);
            var filters = $(this).find('.filters a');

            function initIsotope(filter) {
                if (filter == undefined)
                    filter = '*';
                $el.find('.portfolio-thumbs').isotope({
                    // options
                    itemSelector:'.portfolio-item',
                    layoutMode:'fitRows',
                    filter:filter
                });
                $(window).trigger('resize');
            }

            initIsotope();

            filters.on('click', function () {
                var $filter_el = $(this);
                var $fsel = $filter_el.data('filter');

                filters.removeClass('active');
                $filter_el.addClass('active');
                initIsotope($fsel);
            });
        });
    }

})(jQuery);