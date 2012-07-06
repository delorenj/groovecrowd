require.config({
//  baseUrl: '/js/',
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
    // fosrouter: '../bundles/fosjsrouting/js/router',
    text: "lib/text" 
  },

  shim: {
    "bootstrap": {
        deps: ["jQuery"],
        exports: "$"
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