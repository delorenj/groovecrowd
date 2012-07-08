define([
	'gc/MediaGallery/app/asset'], function(Asset) {

	var assets = Backbone.Collection.extend({
		model: Asset,

	    url: "/project/" + $('#projectHeader').attr('data-id') + "/media",

		select: function(asset){
			this.selected = asset;
		},

		getSelected: function(){
			if(this.selected === undefined) {
				console.log("none selected!");
				this.select(this.first());
			} else {
				console.log("selected: " + this.selected);
			}
			console.log(this.selected.toJSON());
			return this.selected;
		}	    
	});
	return assets;
});
