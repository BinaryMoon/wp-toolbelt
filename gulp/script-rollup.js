/* jshint esnext: true */
'use strict';

// 'amd', 'cjs', 'es', 'iife' or 'umd'

const { dest } = require( 'gulp' );
const uglify = require( 'gulp-uglify' );
const size = require( 'gulp-filesize' );
const babel = require( 'gulp-babel' );
const rollup = require( 'rollup-stream' );
const rename = require( 'gulp-rename' );
const source = require( 'vinyl-source-stream' );
const buffer = require( 'vinyl-buffer' );

function process_scripts( slug ) {

	const destination = './modules/' + slug + '/';
	const script_source = './modules/' + slug + '/block.js';

	return rollup( {
		input: script_source,
		format: 'iife'
	} )
		.pipe( source( 'block.min.js' ) )
		.pipe( buffer() )
		.pipe(
			uglify()
		)
		.pipe( dest( destination ) )
		.pipe( size() );

}

export function rollup_testimonials() {

	return process_scripts( 'testimonials' );

}

export function rollup_projects() {

	return process_scripts( 'projects' );

}

export function rollup_markdown() {

	return process_scripts( 'markdown' );

}
