App.CommentsView = Backbone.View.extend({

    el: $('#comments'),

    initialize:function () {
    	_.bindAll(this, 'render');
        this.model.bind("reset", this.render, this);

    },
 
    render:function (eventName) {
        _.each(this.model.models, function (comment) {
            this.appendComment(comment);
        }, this);

        return this;
    },

    appendComment: function(comment) {
		$(this.el).append(new App.CommentView({model:comment}).render().el);
    }
});
