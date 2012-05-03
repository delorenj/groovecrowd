(function( gcproject, $, undefined ) {
    //Private Property
    var isHot = true;

    //Public Property
    gcproject.ingredient = "Bacon Strips";

    //Public Method
    gcproject.init = function() {
        $(".selectFormChoice")
            .click(function() {
                $("input[type='hidden']").val($(this).attr("id"));
                $(this).closest(".selectForm").trigger("submit");
            })
    };

    gcproject.initCategorySelect = function(){
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
}( window.gcproject = window.gcproject || {}, jQuery ));


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

    gcproject.init();
});