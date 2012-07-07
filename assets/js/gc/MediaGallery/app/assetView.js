define(['text!/gc/MediaGallery/templates/asset'], function(html) {
        var view = Backbone.View.extend({

          tagName: 'li',
          className: 'asset span2',
          template: Handlebars.compile(html),

          render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        }
    });
    return view;
});
