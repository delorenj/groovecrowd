require.config({
//  baseUrl: '/js/',
  paths: {
    json2: 'lib/json2',    
    jQuery: 'lib/jquery/jquery',
    Underscore: 'lib/underscore',
    Backbone: 'lib/backbone',
    Handlebars: 'lib/handlebars',
    Moment: 'lib/moment',
    Countdown: 'lib/countdown',
    Bootstrap: 'lib/twitter-bootstrap/bootstrap',
    SWFUpload: 'lib/swfupload'
  }

});

require([

  // Load our app module and pass it to our definition function
  'app'

], function(App){
  // The "app" dependency is passed in as "App"
  // Again, the other dependencies passed in are not "AMD" therefore don't pass a parameter to this function
  App.initialize();
});