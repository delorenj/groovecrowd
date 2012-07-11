define([
  'gc/MediaGallery/app/videoView',
  'gc/MediaGallery/app/imageView',
  'gc/MediaGallery/app/audioView',  
  'underscore'], function(VideoView, ImageView, AudioView, _) {

    var view = Backbone.View.extend({

      el: $('#mediaGallery div.primary'),
      viewType: null,

      initialize: function(){
        _.bindAll(this, 'render');
        this.viewType = this.collection.getSelected().get("assetType");

      },

      render: function() {
        var that = this;
        $(this.el).html(function() {
          switch(that.viewType){
            case "image":
              return new ImageView({model: that.collection.getSelected()}).render().el;
            case "video":
              return new VideoView({model: that.collection.getSelected()}).render().el;
            case "audio":
              return new AudioView({model: that.collection.getSelected()}).render().el;
            default:
              console.log("unknown asset type: " + this.collection.getSelected().get("assetType"));  
          }
        });
        return this;
      }

    });
    return view;
});
