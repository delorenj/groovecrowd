define([
  'gc/GrooveGallery/app/grooveView'], function(GrooveView) {

    var view = Backbone.View.extend({

      el: $('#groove-grid ul'),

      initialize: function(options) {
        var that = this;
        _.bindAll(this, 'render');
        this.collection.bind('add', function(groove) {
          that.appendGroove(groove);
        });

      },

      render: function(eventName) {
        var that = this;
        _.each(this.collection.models, function(groove) {
          that.appendGroove(groove);
        }, this);

        return this;
      },

      appendGroove: function(groove) {
        $(this.el).append(new GrooveView({model: groove}).render().el);
      }
    });
    return view;
});
