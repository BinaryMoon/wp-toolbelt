/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const concat = require( 'gulp-concat' );
const uglify = require( 'gulp-uglify' );
const size = require( 'gulp-filesize' );
const babel = require( 'gulp-babel' );

function process_scripts( slug, type = 'js', name = 'script' ) {

	const destination = './modules/' + slug + '/';
	const source = './modules/' + slug + '/src/' + type + '/**.js';

	return src( source )
		.pipe(
			concat( name + '.min.js' )
		)
		.pipe(
			babel( { presets: [ '@babel/preset-env' ] } )
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

export function scripts_testimonials() {

	return process_scripts( 'testimonials', 'block', 'block' );

}

export function scripts_projects_block() {

	return process_scripts( 'projects', 'block', 'block' );

}