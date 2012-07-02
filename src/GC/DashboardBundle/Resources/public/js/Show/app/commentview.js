App.CommentView = Backbone.View.extend({

    tagName:"article",
	className: "comment", 
    template: Handlebars.compile($("#comment-template").html()),
 
    render:function (eventName) {
    	// var date = this.get('createdAt');
    	// if(date) this.set("createdAt", {date: moment(date.date).fromNow()});    	
    	var context = this.model.toJSON();

    	// if(context.createdAt) {
    	// 	context.createdAt.formattedDate = moment(context.createdAt.date, "YYYY-MM-DD HH:mm:ss").fromNow();	
    	// 	console.log("---->actual: " + context.createdAt.date, "YYYY-MM-DD HH:mm:ss");
    	// 	console.log("---->moment: " + moment(context.createdAt.date, "YYYY-MM-DD HH:mm:ss"));
    	// 	console.log("---->formatted: " + moment(context.createdAt.date, "YYYY-MM-DD HH:mm:ss").fromNow());

    	// } 

    	// console.log("New render context for model: " + JSON.stringify(context));
        $(this.el).html(this.template(context));
        this.delegateEvents();
        return this;
    }
});
