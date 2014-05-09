module.exports = function (grunt) {

	var S = require('string');

	// Project configuration.
	grunt.initConfig({
		pkg : grunt.file.readJSON('package.json'),
		// Before generating any new files, remove any previously-created files.
		clean : {
			main : ['Dockerfile']
		},

		exec : {
			grunt_help : 'grunt --help',
			echo_test : {
				cmd : function (name) {
					return 'echo ' + name + ' ...';
				}
			},
			// dk = docker / ubuntu 14.04 version
			// http://jimhoskins.com/2013/07/27/remove-untagged-docker-images.html
			dk_rm : {
				cmd : 'sudo docker.io rm $(sudo docker.io ps -a -q)',
				exitCodes : [0, 1, 2]
			},
			dk_rmi : {
				cmd : 'sudo docker.io rmi $(sudo docker.io images | grep "^<none>" | awk "{print $3}")',
				exitCodes : [0, 1, 2]
			},
			dk_ps : {
				cmd : 'sudo docker.io ps',
				exitCodes : [0, 1, 2]
			},
			dk_ip : {
				cmd : 'sudo docker.io ps -q | xargs -n 1 sudo docker.io inspect --format "{{ .Name }} {{ .NetworkSettings.IPAddress }}"',
				exitCodes : [0, 1, 2, 123]
			},
			dk_stop_all : {
				cmd : 'sudo docker.io stop $(sudo docker.io ps -q)',
				exitCodes : [0, 1, 2]
			},
			dk_images_grep : {
				cmd : function (img) {
					return 'sudo docker.io images | grep ' + img;
				},
				exitCodes : [0]
			},
			dk_build : {
				cmd : function (img) {
					return 'sudo docker.io build -t="' + img + '" .';
				},
				exitCodes : [0]
			},
			dk_run_ssl : {
				cmd : function (img) {
					//var name = 'basic-' + img.replace('/', '-');
					return 'sudo docker.io run -d -p 443:443 -p 80:80 -p 8022:22 ' + img;
				},
				exitCodes : [0]
			},

			opt : {
				cmd : '<%=grunt.option("exec.cmd")%>',
				exitCodes : [0]
			},
			dk_run_http : {
				cmd : function (img, tag, port) {
					//var name = 'ssl-' + img.replace('/', '-');
					return 'sudo docker.io run -d -p ' + port + ':80 ' + img + ":" + tag;
				},
				exitCodes : [0]
			},
			dk_run_basic : {
				cmd : function (img) {
					//var name = 'ssl-' + img.replace('/', '-');
					return 'sudo docker.io run -d -p 80:80 -p 8022:22 ' + img;
				},
				exitCodes : [0]
			}
		},

		concat : {
			basic : {
				src : [
					'dockerfiles/Dockerfile.header',
					'dockerfiles/Dockerfile.config',
					'dockerfiles/Dockerfile.user',
					'dockerfiles/Dockerfile.grunt',
					'dockerfiles/Dockerfile.footer',
				],
				dest : 'Dockerfile',
			},
		},

	});

	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-exec');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-zip');
	grunt.loadNpmTasks('grunt-contrib-concat');

	function checkImgArg(img) {
		console.log('Check docker image :' + img);
		if (S(img).isEmpty()) {
			grunt.fail.fatal('docker image name must provide. ');
			return;
		}
	}

	grunt.registerTask('dk-build', 'build docker image', function (img) {
		checkImgArg(img);
		grunt.task.run('exec:dk_build:' + img, 'exec:dk_images_grep:' + img);
	});

	grunt.registerTask('yrunt', 'run grunt in container, ex grunt yrunt:test/img --target=index-ip', function (img) {
		checkImgArg(img);
		// console.log(this.args);
		var target = grunt.option('target') || '';
		//console.log(target);
		console.log('run a container and inject Gruntfile.js.inject to the container.');
		// pipe file into container only in attached mode(-d not work) 
		cmd = 'cat Gruntfile.js.inject | sudo docker.io run -i -p 80:80 ' + img + ' /yrunt.sh ' + target + ' &';
		runexec(cmd);
	});
	
	function runexec(cmd){
	console.log(cmd);
		grunt.option("exec.cmd", cmd);
		grunt.task.run('exec:opt');
	}


	grunt.registerTask('dk-stop-all', 'Stop all docker container', ['exec:dk_stop_all']);
	grunt.registerTask('dk-psip', 'docker ps and ip', ['exec:dk_ps', 'exec:dk_ip']);
	grunt.registerTask('dk-clean', ['exec:dk_rm', 'exec:dk_rmi']);
	// grunt.registerTask('df-basic', 'build basic Dockerfile', ['clean', 'concat:basic']);
	// Default task(s).
	grunt.registerTask('default', ['exec:grunt_help']);

};
