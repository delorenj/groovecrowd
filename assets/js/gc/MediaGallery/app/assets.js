define([
	'gc/MediaGallery/app/asset'], function(Asset) {

	var assets = Backbone.Collection.extend({
		model: Asset,
	    url: "/project/" + $('#projectHeader').attr('data-id') + "/media",
	});
	return assets;
});
