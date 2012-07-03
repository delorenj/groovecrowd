(function(gc_package_select, $, undefined ) {

  var buttons;

  //Public Methods
  gc_package_select.init = function() {
    $(':button').button();

    buttons = $('#package-select-controls').find(':button');

    $(buttons).each(function(i) {
      $(this).click(function() {
        if ($(this).hasClass('active')) {
          return false;
        }
        $(buttons).each(function() {
          $(this).removeClass('active');
        });
        $('#packageSelection_package').val($(this).attr('id'));
      });

      if ($(this).hasClass('active')) {
        $('#packageSelection_package').val($(this).attr('id'));
      }
    });


  };

}(window.gc_package_select = window.gc_package_select || {}, jQuery));


$(document).ready(function() {

  gc_package_select.init();
});
