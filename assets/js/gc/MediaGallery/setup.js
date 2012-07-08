require([
    'gc/MediaGallery/app/assets',
    'gc/MediaGallery/app/assetIndexView',
    'gc/MediaGallery/app/primaryView',
    'jwplayer'], function(Assets, AssetIndexView, PrimaryView, jwplayer) {

    var assets = new Assets();
    assets.fetch({add: true, success: function() {
        var indexView = new AssetIndexView({collection: assets}).render().el;
//      var primaryView = new PrimaryView({model: assets.getSelected()}).render().el;

    }});
    // jwplayer("mediaplayer").setup({
    //     flashplayer: "/js/lib/jwplayer/player.swf",
    //     file: "video1.mp4",
    //     height: 270,
    //     provider: "rtmp",
    //     streamer: "rtmp://s24huxm7iiclgw.cloudfront.net/cfx/st",
    //     width: 480
    // });    
    jwplayer('mediaplayer').setup({
        file: 'test/video1.mp4',        
        width: '640',
        height: '480',
        skin: '/js/lib/jwplayer/grungetape.zip',
        modes: [{
            type: "flash",
            src: "/js/lib/jwplayer/player.swf"
        },{
            type: "html5",
            config: {
                file: "http://dwt7rwekfqghm.cloudfront.net/test/video1.mp4",
                provider: "video"
            }
        }],    
        image: 'https://s3.amazonaws.com/groovecrowd/test/video1.jpg',    
        provider: "rtmp",        
        streamer: 'rtmp://s24huxm7iiclgw.cloudfront.net/cfx/st'

    });
});
