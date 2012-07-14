define(['jwplayer'],function(jwplayer) {
        var view = Backbone.View.extend({

          initialize: function() {

          },

          render: function(eventName) {
            if(window.jwloaded) {
              jwplayer('mediaplayer').remove();
              window.jwloaded = false;
            }
            jwplayer('mediaplayer').setup({
                file: this.model.get('uri'),
                width: '640',
                height: '480',
                skin: '/js/lib/jwplayer/grungetape.zip',
                modes: [{
                    type: "flash",
                    src: "/js/lib/jwplayer/player.swf"
                },{
                    type: "html5",
                    config: {
                        file: "http://dwt7rwekfqghm.cloudfront.net/" + this.model.get('uri'),
                        provider: "video"
                    }
                }],    
                image: this.model.get('thumbUri'),
                provider: "rtmp",        
                streamer: 'rtmp://s24huxm7iiclgw.cloudfront.net/cfx/st'

            });    
            window.jwloaded = true;        
            return this;
        }
    });
    return view;
});
