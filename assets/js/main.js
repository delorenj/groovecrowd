require.config({
  baseUrl: '/js',
  paths: {
    json2: 'lib/json2',    
    jQuery: 'lib/jquery/jquery',
    underscore: 'lib/underscore',
    backbone: 'lib/backbone',
    handlebars: 'lib/handlebars',
    moment: 'lib/moment',
    countdown: 'lib/countdown',
    bootstrap: 'lib/bootstrap',
    SWFUpload: 'lib/swfupload',
    remaining: 'http://www.labs.mimmin.com/countdown/remaining',
    galleria: 'lib/galleria/galleria-1.2.7',    
    jwplayer: 'lib/jwplayer/jwplayer'
    // fosrouter: '../bundles/fosjsrouting/js/router',
  },

  shim: {
    "bootstrap": {
        deps: ["jQuery"],
        exports: "$"
    },

    "galleria": {
        deps: [
          "jQuery",
          "text!/js/lib/galleria/themes/classic/galleria.classic.css"],
        exports: "Galleria"
    },

    "remaining": {
      exports: "remaining"
    },

    "jwplayer": {
      exports: "jwplayer"
    },

    // "fosrouter": {
    //     exports: "Routing"
    // },

    "handlebars": {
        exports: "Handlebars"
    },

    "underscore": {
        exports: "_"
    },

    "backbone": {
        deps: ["json2","handlebars", "underscore", "jQuery"],
        exports: "Backbone"
    }
  }
});
