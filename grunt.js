/*global module:false*/
module.exports = function(grunt) {

  fs = require( "fs" ),
  path = require( "path" ),
  request = require( "request" ),

  libFiles = grunt.file.expandFiles( "assets/js/lib/**/*.js" ),
  gcFiles = grunt.file.expandFiles("assets/js/gc/**/*.js"),

  lessFiles = [
    "bootstrap",
    "responsive"
  ].map(function( component ) {
    return "assets/less/" + component + ".less";
  }),

  cssFiles = [
    "bootstrap",
    "responsive"
  ].map(function( component ) {
    return "assets/css/" + component + ".css";
  }),

  minify = {};

  function mapMinFile( file ) {
    return file.replace( /\.js$/, ".min.js" ).replace(/^assets\//, "web/");
  }

  libFiles.forEach(function( file ) {
    minify[ mapMinFile( file ) ] = [ "<banner>", file ];
  });

  gcFiles.forEach(function( file ) {
    minify[ mapMinFile( file ) ] = [ "<banner>", file ];
  });


  // grunt plugins
  grunt.loadNpmTasks( "grunt-css" );
  grunt.loadNpmTasks( "grunt-html" );
  grunt.loadNpmTasks('grunt-less');
  grunt.loadTasks( "build/tasks" );

  grunt.registerHelper( "strip_all_banners", function( filepath ) {
    return grunt.file.read( filepath ).replace( /^\s*\/\*[\s\S]*?\*\/\s*/g, "" );
  });

  function stripBanner( files ) {
    return files.map(function( file ) {
      return "<strip_all_banners:" + file + ">";
    });
  }

  function stripDirectory( file ) {
    // TODO: we're receiving the directive, so we need to strip the trailing >
    // we should be receving a clean path without the directive
    return file.replace( /.+\/(.+?)>?$/, "$1" );
  }
  // allow access from banner template
  global.stripDirectory = stripDirectory;

  function createBanner( files ) {
    // strip folders
    var fileNames = files && files.map( stripDirectory );
    return "/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - " +
      "<%= grunt.template.today('isoDate') %>\n" +
      "<%= pkg.homepage ? '* ' + pkg.homepage + '\n' : '' %>" +
      "* Includes: " + (files ? fileNames.join(", ") : "<%= stripDirectory(grunt.task.current.file.src[1]) %>") + "\n" +
      "* Copyright (c) <%= grunt.template.today('yyyy') %> <%= pkg.author.name %>; */";
  }

  
  // Project configuration.
  grunt.initConfig({
    pkg: "<json:package.json>",

    meta: {
      banner: createBanner(),
      bannerAll: createBanner( gcFiles ),
      bannerCSS: createBanner( cssFiles )      
    },
    copy: {
      assets: {
        src: ["assets/js/**/*.js", "assets/css/**/*.css"],
        strip: /^assets/,
        dest: "web/"
      }
    },
    less: {
      files: {
        src: [ lessFiles ],
        dest: "assets/css/styles.css"        
      } 
    },    
    lint: {
      files: ['assets/js/gc/**/*.js'] 
    },
    concat: {
      css: {
        src: [ "<banner:meta.bannerCSS>", stripBanner( cssFiles ) ],
        dest: "assets/css/styles.css"
      }
    },
    min: minify,
    watch: {
      jslib: {
        files: 'assets/js/lib/**/*.js',
        tasks: 'concat min'
      },
      gc: {
        files: 'assets/js/gc/**/*.js',
        tasks: 'lint concat min'
      },      
      css: {
        files: 'assets/less/**/*.less',
        tasks: 'less concat cssmin'
      }
      
    },
    cssmin: {
      css: {
        src: '<config:concat.css.dest>',
        dest: 'web/css/styles.min.css'
      }
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        boss: true,
        eqnull: true,
        browser: true,
        smarttabs: true,
        devel: true
      },
      globals: {
        $: false,
        jQuery: true,
        gc_category_select: false,
        gc_package_select: false,
        gc_payment: false,
        gc_project_brief: false,
        Handlebars: false,
        App: false,
        moment: false,
        remaining: false,
        SWFUpload: false,
        Backbone: false,
        _: false,
        Routing: false,
        require: false
      }
    },
    uglify: {}
  });

  // Default task.
  grunt.registerTask('default', 'lint less concat:css cssmin');
  grunt.registerTask('prod', 'lint less concat min cssmin copy');  
  grunt.registerTask('js', 'lint concat:js');
  grunt.registerTask('css', 'less concat:css cssmin copy');
};
