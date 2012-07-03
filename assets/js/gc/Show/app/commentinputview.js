App.CommentInputView = Backbone.View.extend({

    el: $('#commentInput'),

    events: {
        'click .submitComment': 'addComment',
        'keypress': 'showKey'

    },

    initialize: function() {
        _.bindAll(this, 'render', 'addComment', 'showKey');
        this.model.bind('reset', this.render, this);

        var placeholder = new App.Comment({
            id: 'next-comment',
            user: {
                image: $(this.el).attr('data-image'),
                first_name: null,
                last_initial: null
            },
            isComment: false});

        $(this.el).append(new App.CommentView({model: placeholder}).render().el);

    },

    render: function(eventName) {
        return this;
    },

    showKey: function(e) {
        if (e.keyCode === '13') {
            this.addComment();
        }
    },

    addComment: function() {
        var body = $('#commentBody').val();
        if (body === '') { return; }
        var now = moment().fromNow();
        var comment = new App.Comment({
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

        App.comments.add(comment);
    }
});
