import "select2";

(function( $ ) {

	"use strict";
	
	// javascript code here. i.e.: $(document).ready( function(){} ); 
    $(document).ready(function() {
        var select = $('select').not('.woocommerce .checkout .form-row select, .woocommerce-shipping-totals  select');
        select.select2({
            minimumResultsForSearch: Infinity
        });
    });

})(jQuery);