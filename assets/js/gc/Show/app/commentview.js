define(['text!/gc/Show/templates/comment'], function(commentTemplate) {
        var commentView = Backbone.View.extend({

          tagName: 'article',
          className: 'comment',
          template: Handlebars.compile(commentTemplate),

          render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            this.delegateEvents();
            return this;
        }
    });
    return commentView;
});
