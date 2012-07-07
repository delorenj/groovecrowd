define(function() {
  var model = Backbone.Model.extend({
    defaults: {
      image: "img/profiles/default.jpg",
      type: "Image",
      caption: "No Caption"
    }
  });

  return model;
});
