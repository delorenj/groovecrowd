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
    remaining: 'http://www.labs.mimmin.com/countdown/remaining'
    // fosrouter: '../bundles/fosjsrouting/js/router',
  },

  shim: {
    "bootstrap": {
        deps: ["jQuery"],
        exports: "$"
    },

    "remaining": {
      exports: "remaining"
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

require(['bootstrap', 'jQuery','underscore', 'backbone', 'handlebars'], function() {
  require(['gc/Show/setup'], function() {

  });
});