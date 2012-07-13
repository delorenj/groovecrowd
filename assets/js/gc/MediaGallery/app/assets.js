define([
	'gc/MediaGallery/app/asset'], function(Asset) {

	var assets = Backbone.Collection.extend({
		model: Asset,

	    url: "/project/" + $('#projectHeader').attr('data-id') + "/media",

		select: function(asset){
			if(asset != this.selected) {
				this.selected = asset;;
				console.log("selected!");
				this.trigger("select");				
			}
		},

		getSelected: function(){
			if(this.selected === undefined) {
				this.select(this.first());
			} 
			return this.selected;
		}	    
	});
	return assets;
});
