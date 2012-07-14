define(function() {
  var model = Backbone.Model.extend({
    defaults: {
      image: "img/profiles/default.jpg",
      caption: "No Caption",
      state: ""
    },

    select: function(state){
      this.set({'state': state ? 'selected' : ''});
      console.log("set state to: " + state);
    }    
  });

  return model;
});
