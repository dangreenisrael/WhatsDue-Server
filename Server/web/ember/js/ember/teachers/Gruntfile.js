module.exports = function(grunt) {

// Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        emberTemplates: {
            compile: {
                options: {
                    templateBasePath: /templates\//
                },
                files: {
                    "teachers_templates.js": ["templates/**/*.hbs"]
                }
            }
        },
        watch: {
            emberTemplates: {
                files: ['templates/**/*.hbs'],
                tasks: ['emberTemplates']
            }
        }
    });

    grunt.loadNpmTasks('grunt-ember-templates');
    grunt.loadNpmTasks('grunt-contrib-watch');

// Default task(s).
    grunt.registerTask('default', ['emberTemplates']);

};