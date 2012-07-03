App.CommentView = Backbone.View.extend({

    tagName: 'article',
	className: 'comment',
    template: Handlebars.compile($('#comment-template').html()),

    render: function(eventName) {
        $(this.el).html(this.template(this.model.toJSON()));
        this.delegateEvents();
        return this;
    }
});
