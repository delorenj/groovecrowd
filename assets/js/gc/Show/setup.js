require([
	'gc/Show/app/commentinputview',
	'gc/Show/app/comments',
	'gc/Show/app/commentsview',
	'gc/contestlengthwidget'], function(CommentInputView, Comments, CommentsView, ContestLengthWidget) {

	var clw = new ContestLengthWidget();
	
	var comments = new Comments();
	comments.fetch({add: true, success: function() {
		var commentsView = new CommentsView({collection: comments}).render().el;
		var commentInputView = new CommentInputView({model: comments}).render().el;
	}});
});
