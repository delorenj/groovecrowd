define(['text!/gc/MediaGallery/templates/thumb'], function(html) {
        var view = Backbone.View.extend({

          tagName: 'li',
          className: 'span2',
          template: Handlebars.compile(html),

          events: {
            'click': 'selectThumb'
          },

          render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
          },

          selectThumb: function(e) {
            e.preventDefault();
            this.collection.select(this.model);            
          }
    });
    return view;
});
