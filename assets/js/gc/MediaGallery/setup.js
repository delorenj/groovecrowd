require([
    'gc/MediaGallery/app/assets',
    'gc/MediaGallery/app/assetIndexView',
    'gc/MediaGallery/app/primaryView',
    'jwplayer'], function(Assets, AssetIndexView, PrimaryView, jwplayer) {

    var assets = new Assets();
    assets.fetch({add: true, success: function() {
        var primaryView = new PrimaryView({collection: assets}).render().el;        
        var indexView = new AssetIndexView({collection: assets}).render().el;

    }});
   
    // jwplayer('mediaplayer').setup({
    //     file: 'test/video.mp4',        
    //     width: '640',
    //     height: '480',
    //     skin: '/js/lib/jwplayer/grungetape.zip',
    //     modes: [{
    //         type: "flash",
    //         src: "/js/lib/jwplayer/player.swf"
    //     },{
    //         type: "html5",
    //         config: {
    //             file: "http://dwt7rwekfqghm.cloudfront.net/test/video.mp4",
    //             provider: "video"
    //         }
    //     }],    
    //     image: 'https://s3.amazonaws.com/groovecrowd/test/video1.jpg',    
    //     provider: "rtmp",        
    //     streamer: 'rtmp://s24huxm7iiclgw.cloudfront.net/cfx/st'

    // });
});
