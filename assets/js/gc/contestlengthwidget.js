define(['moment', 'text!/gc/templates/arrow', 'remaining'], function(moment, arrowTemplate) {
    var interval = null;
    var widget = $('#contestLengthWidget .bar');
    var arrowContainer = $('#contestLengthWidgetContainer');
    var arrow = Handlebars.compile(arrowTemplate);
    var countdown = $('#contestLengthWidgetCountdown');
    var expiresAt = $(countdown).attr('data-time');
    var secondsRemaining = remaining.getSeconds(expiresAt);
    var contestLength = $(widget).attr('data-length');
    var currentDay = Math.floor(contestLength - secondsRemaining / 60 / 60 / 24);
    var complete = $(widget).attr('data-fill');    
    var larrowLabel = (function() {
      if(complete < 100) {
        return 'Day ' + parseInt(currentDay + 1, 10);  
      } else {
        return 'Day ' + contestLength;
      }
      
    }());
    var larrow = arrow({id: 'larrow', label: larrowLabel, offset: 5});

    var init = function() {
      $('#contestLengthWidget .bar').css('transition', 'none');
      initProgressBar();
      initCountdownTimer();
    };

    function initProgressBar() {
      $(widget).width(complete + '%');
      $(arrowContainer).prepend(larrow);
      if(complete < 100) {
        setPercentComplete('larrow', (currentDay / contestLength) * 100);        
      } else {
        setPercentComplete('larrow', 100);
      }

    }

    function initCountdownTimer() {
      if (remaining.getSeconds(expiresAt) <= 86400) {
        interval = setInterval(
            function() {
              var left = remaining.getSeconds(expiresAt);
              if(left > 0) {
                $(countdown).html(remaining.getString(left, null, false) + ' left!');
              } else {
                $(countdown).html("Contest ended " + moment(expiresAt).format('dddd, MMMM Do YYYY, h:mm a'));
                clearInterval(interval);
              }
                
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
