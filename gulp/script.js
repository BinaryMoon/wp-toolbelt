/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const concat = require( 'gulp-concat' );
const uglify = require( 'gulp-uglify' );
const size = require( 'gulp-filesize' );
const babel = require( 'gulp-babel' );


function process_scripts( slug ) {

	const destination = './modules/' + slug + '/';
	const source = './modules/' + slug + '/src/js/**.js';

	let name = 'script';

	return src( source )
		.pipe(
			concat( name + '.min.js' )
		)
		.pipe(
			babel()
		)
		.pipe(
			uglify()
		)
		.pipe( dest( destination ) )
		.pipe( size() );

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
