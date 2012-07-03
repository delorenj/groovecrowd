App.CommentsView = Backbone.View.extend({

  el: $('#comments'),

  initialize: function(options) {
    var that = this;
    _.bindAll(this, 'render', 'appendComment');
    this.collection.bind('add', function(model) {
      that.appendComment(model);
    });

  },

  render: function(eventName) {
    var that = this;
    _.each(this.collection.models, function(comment) {
      that.appendComment(comment);
    }, this);

    return this;
  },

  appendComment: function(comment) {
    $(this.el).append(new App.CommentView({model: comment}).render().el);
  }
});
