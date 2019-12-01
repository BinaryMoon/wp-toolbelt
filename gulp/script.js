/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const uglify = require( 'gulp-uglify' );
const size = require( 'gulp-filesize' );
const rename = require( 'gulp-rename' );
const babel = require( 'gulp-babel' );

function process_scripts( slug ) {

	const destination = './modules/' + slug + '/';
	const source = './modules/' + slug + '/src/js/**.js';

	return src( source )
		.pipe(
			babel()
		)
		.pipe(
			uglify()
		)
		.pipe(
			rename(
				( path ) => {
					path.basename += '.min';
				}
			)
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

export function scripts_contact_form() {

	return process_scripts( 'contact-form' );

}
