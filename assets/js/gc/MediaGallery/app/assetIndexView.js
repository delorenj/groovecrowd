define([
  'gc/MediaGallery/app/thumbView'], function(ThumbView) {

    var view = Backbone.View.extend({

      el: $('#mediaGallery ul.thumbnails'),


      initialize: function(options) {
        var that = this;
        _.bindAll(this, 'render');
        this.collection.bind('add', function(asset) {
          that.appendAsset(asset);
        });

      },

      render: function(eventName) {
        var that = this;
        _.each(this.collection.models, function(asset) {
          that.appendAsset(asset);
        }, this);

        return this;
      },

      appendAsset: function(asset) {
        $(this.el).append(new ThumbView({model: asset, collection: this.collection}).render().el);
      }
    });
    return view;
});
