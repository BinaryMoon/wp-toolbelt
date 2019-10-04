/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const concat = require( 'gulp-concat' );
const uglify = require( 'gulp-uglify' );
const rename = require( 'gulp-rename' );

function process_scripts( slug ) {

	const destination = './modules/' + slug + '/';
	const source = './modules/' + slug + '/src/js/**.js';

	return src( source )
		.pipe(
			concat( 'script.js' )
		)
		//.pipe( dest( destination ) )
		.pipe(
			uglify()
		)
		.pipe(
			rename( 'script.min.js' )
		)
		.pipe( dest( destination ) );

}

export function scripts_cookieBanner() {

	return process_scripts( 'cookie-banner' );

}

export function scripts_infiniteScroll() {

	return process_scripts( 'infinite-scroll' );

}

export function scripts_spam() {

	return process_scripts( 'spam-blocker' );

}
