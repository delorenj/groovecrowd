App.CommentsView = Backbone.View.extend({

    el: $('#comments'),
 
    initialize:function () {
        this.model.bind("reset", this.render, this);
    },
 
    render:function (eventName) {
        _.each(this.model.models, function (comment) {
            $(this.el).append(new App.CommentView({model:comment}).render().el);
        }, this);
        return this;
    }
});
