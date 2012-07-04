define([
// Load the original jQuery source file
  'order!lib/jquery/jquery.min'
], function(){
  // Tell Require.js that this module returns a reference to jQuery
  return jQuery;
});