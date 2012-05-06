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

    //Private Method
    function addItem( item ) {
        if ( item !== undefined ) {
            console.log( "Adding " + $.trim(item) );
        }
    }    
}( window.gc_project = window.gcproject || {}, jQuery ));


$(document).ready(function() {
    // $("#projectTypeForm").submit(function() {
    //    $.post($("#projectTypeForm").attr("action"), {
    //        projectType: $("#projectType").val()
    //    },function(data){
   
    //         if(data.responseCode==200 ){           
    //             gcproject.initCategorySelect()
    //         }
    //        else if(data.response==400){//bad request
    //            $('#output').html(data.msg);
    //       }
       
    //    },"json");

    //   return false;        
    // });

    gc_project.init();
});