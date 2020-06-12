/* global confirm, redux, redux_change */
(function ($) {
    "use strict";
    
    $.fn.redux_select_preview = function () {
        $(this).each(function () {
            var url = $(this).find(':selected').data('preview');
            $(this).closest('.container-select-preview').find('.preview img').attr('src', url);
        });
    };
    
    jQuery(document).ready(function () {
        
        $('.redux-select-images').redux_select_preview();
        
        $(document).on('change', '.redux-select-images', function () {
            $(this).redux_select_preview();
        });
        
    });
})(jQuery);

