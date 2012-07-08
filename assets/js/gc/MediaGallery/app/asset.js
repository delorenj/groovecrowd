define(function() {
  var model = Backbone.Model.extend({
    defaults: {
      image: "img/profiles/default.jpg",
      type: "Image",
      caption: "No Caption",
      state: ""
    },

    select: function(state){
      this.set({'state': state ? 'selected' : ''});
    }    
  });

  return model;
});
