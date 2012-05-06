(function( gc_project_brief, $, undefined ) {

    //Public Methods
    gc_project_brief.init = function() {
      
    };

    gc_project_brief.onRemoveTag = function(tag) {
        var project_id = $("form[id^='project']").attr("id").split("-")[1]         
        $.post(Routing.generate('project_remove_tag', { "id": project_id, "tag": tag }));
    }
 
   
}( window.gc_project_brief = window.gc_project_brief || {}, jQuery ));


$(document).ready(function() {
    $(".gc-control-label > label").addClass("control-label");
    // $(".gc-radio label").addClass("radio");
    $(".tag-widget").tagsInput({
        'width': '320px',
        'placeholderColor': '#369BD7',
        'onRemoveTag': gc_project_brief.onRemoveTag
    });

    gc_project_brief.init();
});