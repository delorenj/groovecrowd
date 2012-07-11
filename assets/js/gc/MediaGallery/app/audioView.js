define(['require'],function() {
        var view = Backbone.View.extend({

          initialize: function() {

          },

          render: function(eventName) {
            $(this.el).html("<div id='mediaplayer'></div>");
            return this;
        }
    });
    return view;
});
