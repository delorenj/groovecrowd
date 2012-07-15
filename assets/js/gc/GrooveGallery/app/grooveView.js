define(['text!/gc/GrooveGallery/templates/groove'], function(html) {
        var view = Backbone.View.extend({

          tagName: 'li',
          className: 'groove span3',
          template: Handlebars.compile(html),

          render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
          }

    });
    return view;
});
