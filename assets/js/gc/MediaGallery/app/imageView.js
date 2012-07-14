define(['text!/gc/MediaGallery/templates/image'], function(html) {
        var view = Backbone.View.extend({

          tagName: 'li',
          template: Handlebars.compile(html),

          render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        }
    });
    return view;
});
