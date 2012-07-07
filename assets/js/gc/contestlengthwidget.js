define(['moment', 'text!/gc/templates/arrow', 'remaining'], function(moment, arrowTemplate) {
    var widget = $('#contestLengthWidget .bar');
    var arrowContainer = $('#contestLengthWidgetContainer');
    var arrow = Handlebars.compile(arrowTemplate);
    var countdown = $('#contestLengthWidgetCountdown');
    var expiresAt = $(countdown).attr('data-time');
    var secondsRemaining = remaining.getSeconds(expiresAt);
    var contestLength = $(widget).attr('data-length');
    var currentDay = Math.floor(contestLength - secondsRemaining / 60 / 60 / 24);
    var larrowLabel = (function() {
      return 'Day ' + parseInt(currentDay + 1, 10);
    }());
    var larrow = arrow({id: 'larrow', label: larrowLabel, offset: 5});

    var init = function() {
      initProgressBar();
      initCountdownTimer();
    };

    function initProgressBar() {
      var complete = $(widget).attr('data-fill');
      $(widget).width(complete + '%');
      $(arrowContainer).prepend(larrow);
      setPercentComplete('larrow', (currentDay / contestLength) * 100);

    }

    function initCountdownTimer() {
      if (remaining.getSeconds(expiresAt) <= 86400) {
        setInterval(
            function() {
                      $(countdown).html(remaining.getString(remaining.getSeconds(expiresAt), null, false) + ' left!');
            }, 1000
        );
      } else {
        var date = moment().add('seconds', secondsRemaining).fromNow();
        $(countdown).html('Contest ends ' + date);
      }
    }

    function setPercentComplete(arrow, val) {
      $('#' + arrow).css('left', val + '%');
    }

    function getPercentageFromRemainingTime(secondsLeft) {

    }

  return init;
});
