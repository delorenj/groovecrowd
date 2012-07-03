(function($) {

	App.comments = new App.Comments();
	App.comments.fetch({add: true, success: function() {
		App.commentsView = new App.CommentsView({collection: App.comments}).render().el;
		App.commentInputView = new App.CommentInputView({model: App.comments}).render().el;
	}});

}(jQuery));
