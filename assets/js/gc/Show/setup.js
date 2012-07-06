require([
	'gc/Show/app/commentinputview',
	'gc/Show/app/comments',
	'gc/Show/app/commentsview'], function(CommentInputView, Comments, CommentsView) {

	var comments = new Comments();
	comments.fetch({add: true, success: function() {
		var commentsView = new CommentsView({collection: comments}).render().el;
		var commentInputView = new CommentInputView({model: comments}).render().el;
	}});
});
