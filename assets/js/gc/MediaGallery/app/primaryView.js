define([
  'gc/MediaGallery/app/videoView',
  'gc/MediaGallery/app/imageView',
  'gc/MediaGallery/app/audioView',  
  'underscore',
  'jwplayer'], function(VideoView, ImageView, AudioView, _, jwplayer) {

    var view = Backbone.View.extend({

      el: $('#mediaGallery div.primary'),

      initialize: function(){
        _.bindAll(this, 'render');
        this.collection.bind('select', this.render);  
      },

      render: function() {
        var that = this;

        if(window.jwloaded) {
          jwplayer('mediaplayer').remove();
          window.jwloaded = false;
        }

        $(this.el).html(function() {
          switch(that.collection.getSelected().get("assetType")){
            case "image":
              return new ImageView({model: that.collection.getSelected()}).render().el;
            case "video":
              return new VideoView({model: that.collection.getSelected()}).render().el;
            case "audio":
              return new AudioView({model: that.collection.getSelected()}).render().el;
            default:
              console.log("unknown asset type: " + that.collection.getSelected().get("assetType"));  
          }
        });
        return this;
      }

    });
    return view;
});
