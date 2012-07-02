App.Comment = Backbone.Model.extend({
    defaults: {
    	id: "new-comment",
        isComment: true
    },

    url: Routing.generate("project_comments", {"id": $('#projectHeader').attr('data-id')}),

    initialize: function() {
    	var date = this.get('createdAt');
    	if(date) this.set("createdAt", {date: moment(date.date).fromNow()});
    }
});
