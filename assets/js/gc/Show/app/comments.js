define([
	'jQuery',
	'backbone',
	'gc/Show/app/comment'], function($, Backbone, Comment) {

	var comments = Backbone.Collection.extend({
		model: Comment,
		url: Routing.generate('project_comments', {'id': $('#projectHeader').attr('data-id')})
	});
	return comments;
});
