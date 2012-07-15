require([
    'gc/GrooveGallery/app/grooves',
    'gc/GrooveGallery/app/grooveGrid',
    'raty'], function(Grooves, GrooveGrid, raty) {

    var grooves = new Grooves();
    grooves.fetch({add: true, success: function() {
        var view = new GrooveGrid({collection: grooves}).render().el;   
        $('.rating').raty({
            score: function() {
                return $(this).attr('data-rating');
            },
            path: "/img"
        });
        var readonly = parseInt($(".rating").first().attr('data-ro'),10) === 0 ? false:true;      
        $(".rating").raty("readOnly", readonly);
    }});
});
