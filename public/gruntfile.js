module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		less: {
			production: {
				options: {
					cleancss: true
				},
				files: {
					'css/style.css': 'less/style.less'
				}
			},
			development: {
				files: {
					'css/style.dev.css': 'less/style.less'
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-less');

	grunt.registerTask('default', ['less']);

};