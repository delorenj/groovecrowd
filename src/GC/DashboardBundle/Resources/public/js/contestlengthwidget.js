(function(ContestLengthWidget, $) {
    var widget = $("#contestLengthWidget .bar");
    var arrowContainer = $("#contestLengthWidgetContainer");
    var arrow = Handlebars.compile($("#contestLengthWidgetArrowTemplate").html());
    console.log(arrow);
    var countdown = $("#contestLengthWidgetCountdown");    
    var expiresAt = $(countdown).attr("data-time");
    var larrow = arrow({label: "Day 1"});
    var rarrow = arrow({label: "Day 15"});
    
    ContestLengthWidget.init = function() {
        initProgressBar();
        initCountdownTimer();
    }

    function initProgressBar() {
        complete = $(widget).attr('data-fill');
        setPercentComplete(larrow, complete);
        setPercentComplete(rarrow, 100);        
        $(widget).width(complete);
        $(arrowContainer).prepend(rarrow);
        $(arrowContainer).prepend(larrow);
    }

    function initCountdownTimer() {
        setInterval(
            function() {
                $(countdown).html(remaining.getString(remaining.getSeconds(expiresAt), null, false) + ' left!');
            }, 1000
        );
    }

    function setPercentComplete(arrow, val) {
        $(arrow).css("left", val + "%");
    }

    function getPercentageFromRemainingTime(secondsLeft) {

    }

})(window.App.ContestLengthWidget = window.App.ContestLengthWidget || {}, jQuery);


$(document).ready(function() {    
    App.ContestLengthWidget.init();
});