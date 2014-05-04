module.exports = function (grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg : grunt.file.readJSON('package.json'),
		// Before generating any new files, remove any previously-created files.
		clean : {
			main : ['build']
		},

		po2mo : {
			files : {
				src : 'lang/*.po',
				expand : true,
			},
		},

		compress : {
			main : {
				options : {
					archive : 'build/y12-shortcode-hello-v0.0.1.zip'
				},
				files : [{
						src : ['**/*', '!node_modules/**', '!package.json', '!Gruntfile.js', '!.gitignore'],
						dest : 'y12-shortcode-hello/'
					}
				]
			}
		}

	});

	grunt.loadNpmTasks('grunt-contrib-clean');
	// Load the plugin that provides the "uglify" task.
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.loadNpmTasks('grunt-po2mo');

	// Default task(s).
	grunt.registerTask('default', ['clean', 'po2mo','compress']);

};
