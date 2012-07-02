App.CommentInputView = Backbone.View.extend({

    el: $('#commentInput'),
 
 	events: {
 		'click .submitComment': 'addComment'
 	},

    initialize:function () {
        _.bindAll(this, 'render', 'addComment');
        this.model.bind("reset", this.render, this);

        var placeholder = new App.Comment({
            id: "next-comment", 
            user: {
                image: $(this.el).attr("data-image"),
                first_name: null,
                last_initial: null
            },
            isComment: false});

        $(this.el).append(new App.CommentView({model:placeholder}).render().el);        

    },
 
    render:function (eventName) {
        return this;
    },

    addComment: function() {
        var now = moment().fromNow();
        var comment = new App.Comment({
            body: $("#commentBody").val(),
            user: {
                image: $(this.el).attr("data-image"),
                first_name: $(this.el).attr("data-first"),
                last_initial: $(this.el).attr("data-last")
            },
            createdAt: {
                date: now
            }
        });

        // comment.save({
        //     success: function() {
        //         alert("yay!");
        //     },
        //     error: function() {
        //         alert("boo");
        //     }
        // });
        console.log("addComment: " + JSON.stringify(comment));
        App.comments.add(comment);
    }
});
