(function(ContestLengthWidget, $) {
    var widget = $("#contestLengthWidget .bar");
    var arrowContainer = $("#contestLengthWidgetContainer");
    var arrow = Handlebars.compile($("#arrow-template").html());
    var countdown = $("#contestLengthWidgetCountdown");    
    var expiresAt = $(countdown).attr("data-time");
    var larrow = arrow({id: "larrow", label: "Day 1", offset: 5});
    var rarrow = arrow({id: "rarrow", label: "Day 15", offset: 9});
    
    ContestLengthWidget.init = function() {
        initProgressBar();
        if(remaining.getSeconds(expiresAt) < 86400) {
            initCountdownTimer();
        } else {
            date = expiresAt;
            $(countdown).html("Contest ends on " + date);
        }
    }

    function initProgressBar() {
        complete = $(widget).attr('data-fill');
        $(widget).width(complete + "%");
        $(arrowContainer).prepend(rarrow);
        $(arrowContainer).prepend(larrow);
        setPercentComplete("larrow", complete);
        setPercentComplete("rarrow", 100);        
    }

    function initCountdownTimer() {
        setInterval(
            function() {
                $(countdown).html(remaining.getString(remaining.getSeconds(expiresAt), null, false) + ' left!');
            }, 1000
        );
    }

    function setPercentComplete(arrow, val) {
        $("#" + arrow).css("left", val + "%");
    }

    function getPercentageFromRemainingTime(secondsLeft) {

    }

})(window.App.ContestLengthWidget = window.App.ContestLengthWidget || {}, jQuery);


$(document).ready(function() {    
    App.ContestLengthWidget.init();
});