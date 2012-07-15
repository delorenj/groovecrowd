define([
	'gc/GrooveGallery/app/groove'], function(Groove) {

	var collection = Backbone.Collection.extend({
		model: Groove,
	    url: "/project/" + $('#projectHeader').attr('data-id') + "/grooves"
	});
	return collection;
});
