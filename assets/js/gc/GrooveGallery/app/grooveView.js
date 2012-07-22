define(['text!/gc/GrooveGallery/templates/groove', 'moment'], function(html, moment) {
        var view = Backbone.View.extend({

          tagName: 'li',
          className: 'groove span4',
          template: Handlebars.compile(html),

          events: {
            'click .icon-flag'  : 'flag',
            'click .rating'     : 'rate'
          },

          render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            console.log(this.model.toJSON());
            return this;
          },

          flag: function(e) {
            e.preventDefault();
            this.model.set('flag', 1);
            this.model.save();
          },

          rate: function(e) {
            this.model.set('rating', $(this.el).find(".rating").raty('score'));
            this.model.save();
          }
    });
    return view;
});
