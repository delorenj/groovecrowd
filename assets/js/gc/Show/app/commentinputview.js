define([
  'moment',
  'gc/Show/app/comment',
  'gc/Show/app/commentview',
  'gc/Show/app/comments'], function(moment, Comment, CommentView, Comments) {
    console.log(CommentView);
    var commentInputView = Backbone.View.extend({

      el: $('#commentInput'),

      events: {
        'click .submitComment': 'addComment',
        'keypress': 'showKey'

      },

      initialize: function() {
        _.bindAll(this, 'render', 'addComment', 'showKey');

        var placeholder = new Comment({
          id: 'next-comment',
          user: {
            image: $(this.el).attr('data-image'),
            first_name: null,
            last_initial: null
          },
          isComment: false});

        $(this.el).append(new CommentView({model: placeholder}).render().el);

      },

      render: function(eventName) {
        return this;
      },

      showKey: function(e) {
        if (e.keyCode === 13) {
          this.addComment();
        }
      },

      addComment: function() {
        var body = $('#commentBody').val();
        if (body === '') { return; }
        var now = moment().fromNow();
        var comment = new Comment({
          body: body,
          user: {
            image: $(this.el).attr('data-image'),
            first_name: $(this.el).attr('data-first'),
            last_initial: $(this.el).attr('data-last')
          },
          createdAt: {
            date: null,
            formattedDate: now
          },
          canDelete: true
        });

        comment.save(null, {
          success: function(model, response) {
            console.log('yay');
            $('#commentBody').val('');
          },
          error: function(model, response) {
            console.log('error posting comment');
          }
        });

        this.model.add(comment);
      }
    });
    return commentInputView;
});
