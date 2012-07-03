App.Comments = Backbone.Collection.extend({
    model: App.Comment,
    url: Routing.generate('project_comments', {'id': $('#projectHeader').attr('data-id')})

});

