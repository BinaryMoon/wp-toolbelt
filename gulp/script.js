/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const concat = require( 'gulp-concat' );
const uglify = require( 'gulp-uglify' );
const size = require( 'gulp-filesize' );

function process_scripts( slug, type = 'js', name = 'script' ) {

	const destination = './modules/' + slug + '/';
	const source = './modules/' + slug + '/src/' + type + '/**.js';

	return src( source )
		.pipe(
			concat( name + '.min.js' )
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
