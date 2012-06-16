$(document).ready(function() {    
    var countdown = $("#contestLengthWidgetCountdown");
    var widget = $("#contestLengthWidget .bar");
    var expiresAt = $(countdown).attr("data-time");
    $(widget).width($(widget).attr('data-fill'));    
    setInterval(
        function() {
            $(countdown).html(
                    remaining.getString(remaining.getSeconds(expiresAt), null, false) + ' left!'
                );

        }, 1000
    );
});