(function($) {

	App.comments = new App.Comments();
	App.comments.fetch({success: function() {
		App.commentsView = new App.CommentsView({model:App.comments}).render().el;
		App.commentInputView = new App.CommentInputView({model:App.comments}).render().el;	
	}});

}(jQuery));
