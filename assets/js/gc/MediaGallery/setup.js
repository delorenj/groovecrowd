require([
	'gc/MediaGallery/app/assets',
	'gc/MediaGallery/app/assetIndexView'], function(Assets, AssetIndexView) {

	var assets = new Assets();
	assets.fetch({add: true, success: function() {
		var indexView = new AssetIndexView({collection: assets}).render().el;
	}});
});
