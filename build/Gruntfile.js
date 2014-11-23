 module.exports = function (grunt) {
 	grunt.initConfig({
 		pkg: grunt.file.readJSON('package.json'),
 		concat: {
 			options: {
 				banner: '/*! APP.common.css@<%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */'
 			},
 			mobileLess: {
 				src: ['src/assets/less/APP_common/*.less'],
 				dest: 'src/assets/less/APP.common_grunt.less',
 				// src: ['src/mobile/less/APP_common/*.less'],
 				// 	dest: 'src/mobile/less/APP.common_grunt.less',
 			}
 		},
 		// less: {
 		// 	development: {
 		// 		options: {
 		// 			compress: false,
 		// 			yuicompress: false
 		// 		},
 		// 		files: {
 		// 			"css/APP.common.css": "src/mobile/less/APP.common_grunt.less",
 		// 			"css/APP.web.index.css": "src/web/less/APP.web.index.less"
 		// 		}
 		// 	},
 		// 	production: {
 		// 		options: {
 		// 			modifyVars: {
 		// 				imagepath_page: '"/misc/images/"',
 		// 				imagepath: '"/misc/images/"'
 		// 			},
 		// 			compress: true,
 		// 			yuicompress: true,
 		// 			optimization: 2
 		// 		},
 		// 		files: {
 		// 			"css/pub/APP.common.css": "src/mobile/less/APP.common_grunt.less",
 		// 			"css/pub/APP.web.index.css": "src/web/less/APP.web.index.less"
 		// 		}
 		// 	}
 		// },
 		// htmlbuild: {
 		// 	mobile: {
 		// 		src: 'src/mobile/html/*.html',
 		// 		desc: './',
 		// 		options: {
 		// 			beautify: true,
 		// 			relative: true,
 		// 			sections: {
 		// 				layout: {
 		// 					footbar: 'src/mobile/html/inc/footbar.html'
 		// 				}
 		// 			}
 		// 		}
 		// 	},
 		// 	web: {
 		// 		src: 'src/web/html/*.html',
 		// 		desc: './'
 		// 	}
 		// },
 		// watch: {
 		// 	options: {
 		// 		livereload: true
 		// 	},
 		// 	grunt: {
 		// 		files: ['Gruntfile.js']
 		// 	},
 		// 	styles: {
 		// 		files: ['src/**/less/*.less', 'src/**/less/**/*.less'],
 		// 		tasks: ['concat:mobileLess', 'less'],
 		// 		options: {
 		// 			nospawn: true
 		// 		}
 		// 	},
 		// 	htmls: {
 		// 		files: ['src/**/html/*.html', 'src/**/html/**/*.html'],
 		// 		tasks: ['htmlbuild'],
 		// 		options: {
 		// 			nospawn: true
 		// 		}
 		// 	}
 		// }
 	});
 	grunt.loadNpmTasks('grunt-contrib-concat');
 	grunt.loadNpmTasks('grunt-contrib-less');
 	grunt.loadNpmTasks('grunt-contrib-watch');
 	grunt.loadNpmTasks('grunt-html-build');
 	grunt.registerTask('default', ['watch']);
 };