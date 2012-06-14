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
            expiresIn: this.model.expiresIn(),
            projectType: this.model.get('projectType'),
            blind: this.model.get('blind'),
            category: this.mode.get('category'),
            payoutGuaranteed: this.model.get('payoutGuaranteed')
        };
        html = source(context);
        $(this.el).html(html);
        return this;
    },

    toggleEnable: function(){
        console.log("Enable toggled");
    }
});
