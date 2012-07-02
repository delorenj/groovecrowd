App.Comment = Backbone.Model.extend({
    defaults: {
        isComment: true
    },

    url: Routing.generate("project_comments", {"id": $('#projectHeader').attr('data-id')}),

    initialize: function() {
    	var date = this.get('createdAt');
    	if(date) this.set("createdAt", {date: moment(date.date).fromNow()});
    },

    // sync: function(method, model, callbacks) {
    // 	$.ajax({
    // 		url: this.url, 
    // 		type: "POST",
    // 		data: model, 
    // 		dataType: "json",
    // 		success: callbacks.success,
    // 		error: callbacks.error
    // 	});

    // }
});
