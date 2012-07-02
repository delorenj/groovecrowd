App.Comment = Backbone.Model.extend({
    defaults: {
        isComment: true
    },

    url: Routing.generate("project_comments", {"id": $('#projectHeader').attr('data-id')}),

    initialize: function() {
    	var date = this.get('createdAt');
    	if(date && date.date) this.set("createdAt", {formattedDate: moment(date.date, "YYYY-MM-DD HH:mm:ss").fromNow()});
    },

});
