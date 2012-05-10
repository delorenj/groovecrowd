(function( gc_package_select, $, undefined ) {

    //Public Methods
    gc_package_select.init = function() {
      
    };
  
}( window.gc_package_select = window.gc_package_select || {}, jQuery ));


$(document).ready(function() {
    $("#package-select-controls").find("button").click(function() {
        return false;
    })

    gc_package_select.init();
});