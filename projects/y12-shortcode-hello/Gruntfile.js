module.exports = function (grunt) {

	// Project configuration.
	grunt.initConfig({
		// plugin id
		pid : "y12-shortcode-hello",
		pluginzip : 'build/<%= pid %>.zip',
		pkg : grunt.file.readJSON('package.json'),
		secret : grunt.file.readJSON('secret.json'),
		// Before generating any new files, remove any previously-created files.
		clean : {
			main : ['build']
		},

		sftp : {
			upload : {
				files : {
					"./" : "<%= pluginzip %>"
				},
				options : {
					path : '/home/docker/tmp',
					host : '<%= secret.host %>',
					port : 8022,
					username : '<%= secret.username %>',
					password : '<%= secret.password %>',
					// why ??
					srcBasePath : "build/",
					showProgress : true
				}
			}
		},

		sshexec : {
			pgup : {
				command : 'cd /home/docker && grunt exec:pgup:<%= pid %>',
				options : {
					host : '<%= secret.host %>',
					port : 8022,
					username : '<%= secret.username %>',
					password : '<%= secret.password %>'
				}
			}
		},

		exec : {
			echo_test : 'echo "This is something"',
			// dk = docker / ubuntu 14.04 version
			// http://jimhoskins.com/2013/07/27/remove-untagged-docker-images.html
			dk_rm : {
				cmd : 'sudo docker.io rm $(sudo docker.io ps -a -q)',
				exitCodes : [1]
			},
			dk_rmi : {
				cmd : 'sudo docker.io rmi $(sudo docker.io images | grep "^<none>" | awk "{print $3}")',
				exitCodes : [1, 2]
			},
			dk_run : {
				// http://y12.tw/wp/2014/05/wordpress-3-9-docker-install/
				cmd : 'sudo docker.io run -d -p 80:80 -p 8022:22 test/wp39',
				exitCodes : [0]
			}
		},

		'phplint' : {
			options : {
				// sudo apt-get install php5-cli
				// which php
				phpCmd : "/usr/bin/php",
				phpArgs : {
					'-lf' : null
				},
				spawnLimit : 10
			},
			all : {
				src : ['*.php', '**/*.php', '!node_modules/**/*.php']
			}
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
					archive : '<%= pluginzip %>'
				},
				files : [{
						src : ['**/*', '!node_modules/**', '!package.json', '!Gruntfile.js', '!.gitignore', '!secret.json'],
						dest : '<%= pid %>/'
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
	grunt.loadNpmTasks('grunt-exec');
	grunt.loadNpmTasks("grunt-phplint");
	grunt.loadNpmTasks('grunt-ssh');

	// Default task(s).
	grunt.registerTask('deploy', ['clean', 'phplint', 'po2mo', 'compress', 'sftp:upload', 'sshexec:pgup']);
	grunt.registerTask('default', ['clean', 'phplint', 'po2mo', 'compress']);

};
