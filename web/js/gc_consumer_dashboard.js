(function($) {

    Backbone.sync = function(method, model, success, error){
        console.log("Sync: " + method + " : " + model);
    }

    var Project = Backbone.Model.extend({
        defaults: {
            title: "",
            description: "",
            organizaion: "",
            payoutGuaranteed: "",
            protection: "",
            contestLength: "",
            enabled: "",
            fullGrooveSetsOnly: "",
            blind: "",
            flags: "",
            projectType: "",
            createdAt: "",
            modifiedAt: "",
            category: ""
        }
    });

    var ProjectCollection = Backbone.Collection.extend({
        model: Project,
        url: Routing.generate("dashboard_consumer_index")

    });

    var ProjectView = Backbone.View.extend({
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
            console.log(html);
            $(this.el).html(html);
            return this;
        },

        toggleEnable: function(){
            console.log("Enable toggled");
        }
    });

    var ProjectCollectionView = Backbone.View.extend({
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
                    projects[x] = new Project(i);
                });
                that.collection = new ProjectCollection(projects);
                that.counter = 0;
                that.render();
            }, "json");
        },

        render: function(){
            $(this.el).append("<ul></ul>");
            _(this.collection.models).each(function(item){
                var projectView = new ProjectView({
                    model: item
                });
                $('ul', this.el).append(projectView.render().el);
            }, this);
        }

    });

    var listView = new ProjectCollectionView();

}(jQuery));
