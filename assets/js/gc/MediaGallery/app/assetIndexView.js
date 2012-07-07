define([
  'gc/MediaGallery/app/assetView'], function(AssetView) {

    var view = Backbone.View.extend({

      el: $('#mediaGallery'),

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
        $(this.el).append(new AssetView({model: asset}).render().el);
      }
    });
    return view;
});
