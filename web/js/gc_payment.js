(function( gc_payment, $, undefined ) {

    var buttons;

    //Public Methods
    gc_payment.init = function() {
    	$(".gc-control-label > label").addClass("control-label");
    };
  
}( window.gc_payment = window.gc_payment || {}, jQuery ));


$(document).ready(function() {

    gc_payment.init();
});