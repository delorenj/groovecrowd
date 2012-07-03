(function( gc_category_select, $, undefined ) {

    gc_category_select.init = function() {
        $(".selectFormChoice")
            .click(function() {
                $("input[type='hidden']").val($(this).attr("id"));
                $(this).find(".selectForm").trigger("submit");
            })
    };

}( window.gc_category_select = window.gc_category_select || {}, jQuery ));


$(document).ready(function() {
    gc_category_select.init();
});