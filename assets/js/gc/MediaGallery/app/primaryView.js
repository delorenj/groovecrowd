define([
  'text!/gc/MediaGallery/templates/image',
  'underscore'], function(html) {

    var view = Backbone.View.extend({

      el: $('#mediaGallery div.primary'),
      className: 'selected image span6',
      template: Handlebars.compile(html),

      initialize: function(){
        _.bindAll(this, 'render');
      },

      render: function() {
        $(this.el).html(this.template(this.model.toJSON()));
        return this;
      }

    });
    return view;
});
