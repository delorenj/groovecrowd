(function( gc_payment, $, undefined ) {

    var buttons;

    //Public Methods
    gc_payment.init = function() {
    	$(".gc-control-label > label").addClass("control-label");
    	$("#login").click(function() {
	        $.post(Routing.generate('fos_user_security_login', { "_username": $("#payment_email").val(), 
                                                                 "_password": $("#payment_plain_password").val() }), 
	        	function(data) {
	        		alert(data);
	        	}
	        );
            return false;
    	})
    };
  
}( window.gc_payment = window.gc_payment || {}, jQuery ));


$(document).ready(function() {

    gc_payment.init();
});