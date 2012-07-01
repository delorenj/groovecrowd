App.Comment = Backbone.Model.extend({
    defaults: {
        id: "",
        image: "http://groovecrowd.local/img/profiles/default.jpg",
        created_at: moment()
    },

    initialize: function() {
    },

    createdAt: function() {
        return moment(this.get('created_at'));
    }
});
