App.ProjectsView = Backbone.View.extend({
    el : $('#groove-list'),

    events : {
//            'click button#add': 'addItem'
    },

    initialize : function(){
        _.bindAll(this, 'render');
        var that = this;
        $.get(Routing.generate("dashboard_consumer_index"), function(response) {
            var projects = new Array;
            _.each(response, function(i,x) {
                projects[x] = new App.Project(i);
            });
            that.collection = new App.Projects(projects);
            that.counter = 0;
            that.render();
        }, "json");
    },

    render: function(){
        $(this.el).append("<ul></ul>");
        _(this.collection.models).each(function(item){
            App.projectView = new App.ProjectView({
                model: item
            });
            $('ul', this.el).append(App.projectView.render().el);
        }, this);
    }

});
