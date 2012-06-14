App.Projects = Backbone.Collection.extend({
    model: App.project,
    url: Routing.generate("dashboard_consumer_index")
});

