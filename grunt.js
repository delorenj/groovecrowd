/*global module:false*/
module.exports = function(grunt) {
  
  // Project configuration.
  grunt.initConfig({
    meta: {
      version: '0.1.0',
      banner: '/*! groovecrowd - v<%= meta.version %> - ' +
        '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
        '* http://www.groovecrowd.com/\n' +
        '* Copyright (c) <%= grunt.template.today("yyyy") %> ' +
        'Jarad DeLorenzo; Licensed MIT */'
    },  
    less: {
      bootstrap: {
        src: ['assets/less/bootstrap.less'],
        dest:'assets/css/bootstraps.css'        
      },
      responsive: {
        src: ['assets/less/responsive.less'],
        dest:'assets/css/responsive.css'        
      }      
    },    
    lint: {
      files: ['assets/js/gc/**/*.js'] 
    },
    concat: {
      css: {
        src: ['assets/css/*.css'],
        dest:'web/css/styles.css'
      },
      jquery: {
        src:  ['assets/js/lib/jquery.min.js','assets/js/lib/plugins/**/*.js'],
        dest: 'web/js/lib/jquery.js'
      },
      swfupload: {
        src:  ['assets/js/swfupload/swfupload.swfobject.js','assets/js/swfupload/swfupload.cookies.js','assets/js/swfupload/swfupload.queue.js','assets/js/swfupload/swfupload.speed.js','assets/js/swfupload/swfupload.js'],
        dest: 'web/js/lib/swfupload.js'
      },
      core: {
        src:  ['<config:concat.jquery.dest>','assets/js/lib/twitter-bootstrap/**/*.js','assets/js/lib/moment.min.js','assets/js/lib/handlebars-1.0.0.beta.6.min.js','assets/js/lib/backbone/underscore.js','assets/js/lib/backbone/json2.js','assets/js/lib/backbone/backbone.js','assets/js/lib/gc/app.js'],
        dest: 'web/js/lib/core.js'
      },
      projectShow: {
        src: ['assets/js/gc/Show/**/*.js'],
        dest: 'web/js/gc/Show/all.js'
      },
      projectCategorySelect: {
        src: ['assets/js/gc/CategorySelect/**/*.js'],
        dest: 'web/js/gc/CategorySelect/all.js'
      },
      projectMediaGallery: {
        src: ['assets/js/gc/MediaGallery/**/*.js'],
        dest: 'web/js/gc/MediaGallery/all.js'
      },
      projectPackageSelect: {
        src: ['assets/js/gc/PackageSelect/**/*.js'],
        dest: 'web/js/gc/PackageSelect/all.js'
      },
      projectPayment: {
        src: ['assets/js/gc/Payment/**/*.js'],
        dest: 'web/js/gc/Payment/all.js'
      },
      projectBrief: {
        src: ['assets/js/gc/ProjectBrief/**/*.js'],
        dest: 'web/js/gc/ProjectBrief/all.js'
      }                              
    },
    min: {
      require: {
        src: 'assets/js/lib/require.js',
        dest: 'web/js/lib/require.min.js'
      },
      core: {
        src: '<config:concat.swfupload.dest>',
        dest: 'web/js/lib/swfupload.min.js'
      },  
      core: {
        src: '<config:concat.core.dest>',
        dest: 'web/js/lib/core.min.js'
      },      
      projectShow: {
        src: '<config:concat.projectShow.dest>',
        dest: 'web/js/gc/Show/all.min.js'
      },
      projectCategorySelect: {
        src: ['web/js/gc/CategorySelect/all.js'],
        dest: 'web/js/gc/CategorySelect/all.min.js'
      },
      projectMediaGallery: {
        src: '<config:concat.projectMediaGallery.dest>',
        dest: 'web/js/gc/MediaGallery/all.min.js'
      },
      projectPackageSelect: {
        src: '<config:concat.projectPackageSelect.dest>',
        dest: 'web/js/gc/PackageSelect/all.min.js'
      },
      projectPayment: {
        src: '<config:concat.projectPayment.dest>',
        dest: 'web/js/gc/Payment/all.min.js'
      },
      projectBrief: {
        src: '<config:concat.projectBrief.dest>',
        dest: 'web/js/gc/ProjectBrief/all.min.js'
      }
    },
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

  grunt.loadNpmTasks('grunt-less');
  grunt.loadNpmTasks('grunt-css');

  // Default task.
  grunt.registerTask('default', 'lint less concat min cssmin');
  grunt.registerTask('js', 'lint concat min');
  grunt.registerTask('css', 'less concat cssmin');
};
