(function( gc_project, $, undefined ) {
    //Private Property
    var isHot = true;

    //Public Property
    gc_project.ingredient = "Bacon Strips";

    //Public Method
    gc_project.init = function() {
        $(".selectFormChoice")
            .click(function() {
                $("input[type='hidden']").val($(this).attr("id"));
                $(this).find(".selectForm").trigger("submit");
            })
    };

    gc_project.initCategorySelect = function(){
        $("#ProjectTypeContainer")
            .animate(
            { left: 200 }, {
             duration: 'slow',
             easing: 'easeOut'
            });            

    }

    gc_project.initBackButton = function(){
        $("#backbutton").click(function() {
            location.href = Routing.generate('project_back');
            return false;
        });
    }

    //Private Method
    function addItem( item ) {
        if ( item !== undefined ) {
            console.log( "Adding " + $.trim(item) );
        }
    }    
}( window.gc_project = window.gcproject || {}, jQuery ));


$(document).ready(function() {
    gc_project.init();
    //gc_project.initBackButton();
});