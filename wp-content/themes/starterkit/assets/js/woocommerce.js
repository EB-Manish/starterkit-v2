(function ($) {
    "use strict";

    // Variable product radio button on product detail page
    $(document).on('change', '.variation-radios input', function () {
        $('.variation-radios input:checked').each(function (index, element) {
            var $el = $(element);
            var thisName = $el.attr('name');
            var thisVal = $el.attr('value');
            $('select[name="' + thisName + '"]').val(thisVal).trigger('change');
        });
    });
    
    $(document).on('woocommerce_update_variation_values', function () {
        $('.variation-radios input').each(function (index, element) {
            var $el = $(element);
            var thisName = $el.attr('name');
            var thisVal = $el.attr('value');
            $el.removeAttr('disabled');
            if ($('select[name="' + thisName + '"] option[value="' + thisVal + '"]').is(':disabled')) {
                $el.prop('disabled', true);
            }
        });
    });

    // Shop page filter using select2.js
    $('.woocommerce-shop .orderby').on('select2:select', function (e) {
        $('.woocommerce-shop .woocommerce-ordering').submit();
    });
})(jQuery);
