define(['text!/gc/GrooveGallery/templates/groove', 'moment'], function(html, moment) {
        var view = Backbone.View.extend({

          tagName: 'li',
          className: 'groove span4',
          template: Handlebars.compile(html),

          render: function(eventName) {
            // this.model.set('length', moment(this.model.get('lengthInMilliseconds')/1000, 's').format('mm:ss'));
             // this.model.set('length', moment('100', 's').format('m:ss'));
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
          }

    });
    return view;
});
