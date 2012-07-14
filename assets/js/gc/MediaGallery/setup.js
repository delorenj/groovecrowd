require([
    'gc/MediaGallery/app/assets',
    'gc/MediaGallery/app/assetIndexView',
    'gc/MediaGallery/app/primaryView'], function(Assets, AssetIndexView, PrimaryView) {

    var assets = new Assets();
    assets.fetch({add: true, success: function() {
        var primaryView = new PrimaryView({collection: assets}).render().el;        
        var indexView = new AssetIndexView({collection: assets}).render().el;

    }});
});
