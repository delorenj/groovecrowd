require([
	'gc/MediaGallery/app/assets',
	'gc/MediaGallery/app/assetIndexView',
	'gc/MediaGallery/app/primaryView',
	'galleria'], function(Assets, AssetIndexView, PrimaryView, Galleria) {

	var assets = new Assets();
	assets.fetch({add: true, success: function() {
		var indexView = new AssetIndexView({collection: assets}).render().el;
//		var primaryView = new PrimaryView({model: assets.getSelected()}).render().el;
		Galleria.loadTheme('/js/lib/galleria/themes/classic/galleria.classic.min.js');
//	    Galleria.run('#galleria');	
		$('#galleria').galleria({
			width: 700,
			height: 467
		});

	}});

});
