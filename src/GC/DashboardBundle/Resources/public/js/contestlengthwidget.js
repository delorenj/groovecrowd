(function(ContestLengthWidget, $) {
    var widget = $("#contestLengthWidget .bar");
    var arrowContainer = $("#contestLengthWidgetContainer");
    var arrow = Handlebars.compile($("#arrow-template").html());
    var countdown = $("#contestLengthWidgetCountdown");    
    var expiresAt = $(countdown).attr("data-time");
    var secondsRemaining = remaining.getSeconds(expiresAt);    
    var contestLength = $(widget).attr("data-length");
    var currentDay = Math.floor(contestLength - secondsRemaining/60/60/24);    
    var larrow = arrow({id: "larrow", label: "Day " + currentDay, offset: 5});
    var rarrow = arrow({id: "rarrow", label: "Day " + contestLength, offset: 9});
    
    ContestLengthWidget.init = function() {
        initProgressBar();
        if(remaining.getSeconds(expiresAt) < 86400) {
            initCountdownTimer();
        } else {
            date = moment().add('seconds', secondsRemaining).fromNow();
            $(countdown).html("Contest ends " + date);
        }
    }

    function initProgressBar() {
        complete = $(widget).attr('data-fill');
        $(widget).width(complete + "%");
        $(arrowContainer).prepend(rarrow);
        $(arrowContainer).prepend(larrow);
        setPercentComplete("larrow", (currentDay/contestLength)*100);
        setPercentComplete("rarrow", 100);        
    }

    function initCountdownTimer() {
        setInterval(
            function() {
                $(countdown).html(remaining.getString(secondsRemaining, null, false) + ' left!');
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