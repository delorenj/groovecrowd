(function(ContestLengthWidget, $) {
    var widget = $("#contestLengthWidget .bar");
    var arrowContainer = $("#contestLengthWidgetContainer");
    var arrow = "<div class='contestLengthWidgetArrow'><h5 style='width: 60px;'>Day 1</h5><img src='/img/arrow-blue-outline-down-23x30.png'></img></div>"
    var countdown = $("#contestLengthWidgetCountdown");    
    var expiresAt = $(countdown).attr("data-time");
    var larrow = $(arrow);
    var rarrow = $(arrow);

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