(function($) {

    Backbone.sync = function(method, model, success, error){
        console.log("Sync: " + method + " : " + model);
    }

    var Project = Backbone.Model.extend({
        defaults: {
            title: "Title",
            description: "Description",
            payout_guaranteed: "0",
            enabled: "1",
            blind: "0",
            flags: "0",
            created_at: "",
            modified_at: "",
            contest_length: "",
            project_type: "",
            protection: "0",
            asset: ""
        }
    });

    var List = Backbone.Collection.extend({
        model: Project,
        url: Routing.generate("dashboard_consumer_index")

    });

    var ProjetView = Backbone.View.extend({
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
                asset: this.model.get('asset')
            };
            html = source(context);

            $(this.el).html(html);
            return this;
        },

        toggleEnable: function(){
            console.log("Enable toggled");
        }
    });

    var ListView = Backbone.View.extend({
        el : $('#groove-list'),

        events : {
//            'click button#add': 'addItem'
        },

        initialize : function(){
            _.bindAll(this, 'render');

            this.collection = new List();
            this.collection.fetch();            
            this.counter = 0;
            this.render();
        },

        render: function(){
            $(this.el).append("<ul></ul>");
            _(this.collection.models).each(function(item){
                appendItem(item);
            }, this);
        }

    });

    var listView = new ListView();

    $.get(Routing.generate("dashboard_consumer_index"), function(response) {
        console.log(response);
    })

}(jQuery));
