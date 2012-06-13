App.ProjectView = Backbone.View.extend({
    tagName: 'li',

    events: {
        'click span.toggle-enable': 'toggleEnable'
    },

    initialize: function(){
        _.bindAll(this, 'render', 'toggleEnable');

        this.model.bind('change', this.render);
    },

    render: function(){
        source = Handlebars.compile($("#project-template").html());
        context = {
            title: this.model.get('title'),
            description: this.model.get('description'),
//                asset: this.model.get('asset')
        };
        html = source(context);
        $(this.el).html(html);
        return this;
    },

    toggleEnable: function(){
        console.log("Enable toggled");
    }
});
