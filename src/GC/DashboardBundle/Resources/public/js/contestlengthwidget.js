(function(ContestLengthWidget, $) {
    var widget = $("#contestLengthWidget .bar");
    var arrowContainer = $("#contestLengthWidgetContainer");
    var arrow = Handlebars.compile($("#arrow-template").html());
    var countdown = $("#contestLengthWidgetCountdown");    
    var expiresAt = $(countdown).attr("data-time");
    var secondsRemaining = remaining.getSeconds(expiresAt);    
    var contestLength = $(widget).attr("data-length");
    var currentDay = Math.ceil(contestLength - secondsRemaining/60/60/24);    
    var larrow = arrow({id: "larrow", label: "Day " + currentDay, offset: 5, direction: "down"});
    var rarrow = arrow({id: "rarrow", label: "Day " + contestLength, offset: 9, direction: "up"});
    
    ContestLengthWidget.init = function() {
        initProgressBar();
        initCountdownTimer();
    }

    function initProgressBar() {
        complete = $(widget).attr('data-fill');
        $(widget).width(complete + "%");
        $(arrowContainer).prepend(rarrow);
        setPercentComplete("rarrow", 100);

        if(remaining.getSeconds(expiresAt) > 86400) {
            $(arrowContainer).prepend(larrow);
            setPercentComplete("larrow", (currentDay/contestLength)*100);
        }
        
    }

    function initCountdownTimer() {
        if(remaining.getSeconds(expiresAt) <= 86400) {
            $("#larrow").hide();
            setInterval(
                function() {
                    $(countdown).html(remaining.getString(remaining.getSeconds(expiresAt), null, false) + ' left!');
                }, 1000
            );
        } else {
            date = moment().add('seconds', secondsRemaining).fromNow();
            $(countdown).html("Contest ends " + date);
        }
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