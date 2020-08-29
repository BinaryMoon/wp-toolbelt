/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const uglify = require( 'gulp-uglify' );
const size = require( 'gulp-filesize' );
const rename = require( 'gulp-rename' );
const babel = require( 'gulp-babel' );
const plumber = require( 'gulp-plumber' );


function process_scripts( source = './modules/**/src/js/**/*.js' ) {

	return src( source )
		.pipe( plumber() )
		.pipe(
			rename(
				path => {
					path.dirname = path.dirname.replace( 'src/js', '' );
					path.extname = '.min.js';
				}
			)
		)
		.pipe(
			babel()
		)
		.pipe(
			uglify()
		)
		.pipe( dest( './modules/' ) )
		.pipe( size() );

}

export function process_module_scripts() {

	return process_scripts();

}
