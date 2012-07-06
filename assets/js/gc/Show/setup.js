require([
	'jQuery',
	'backbone',
	'gc/Show/app/commentinputview',
	'gc/Show/app/comments',
	'gc/Show/app/commentsview'], function($, Backbone, CommentInputView, Comments, CommentsView) {

	var comments = new Comments();
	comments.fetch({add: true, success: function() {
		var commentsView = CommentsView({collection: comments}).render().el;
		var commentInputView = CommentInputView({model: comments}).render().el;
	}});
});
