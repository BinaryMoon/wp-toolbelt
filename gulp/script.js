/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const concat = require( 'gulp-concat' );
const uglify = require( 'gulp-uglify' );
const rename = require( 'gulp-rename' );

function process_scripts( slug ) {

	const destination = './' + slug + '/';
	const source = './' + slug + '/src/js/**.js';

	return src( source )
		.pipe(
			concat( 'script.js' )
		)
		.pipe(
			dest( destination )
		)
		.pipe(
			uglify()
		)
		.pipe(
			rename( 'script.min.js' )
		)
		.pipe( dest( destination ) );

}

export default function scripts() {

	return process_scripts( 'cookie-banner' );

}
