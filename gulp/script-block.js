/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const babel = require( 'gulp-babel' );

function process_scripts( slug ) {

	const destination = './modules/' + slug + '/';
	const script_source = './modules/' + slug + '/src/block/block.js';
	const env = [
		'@babel/preset-env',
		'@wordpress/babel-preset-default'
	];

	return src( script_source )
		.pipe(
			babel( { presets: env } )
		)
		.pipe( dest( destination ) );

}

export function block_testimonials() {

	return process_scripts( 'testimonials' );

}

export function block_projects() {

	return process_scripts( 'projects' );

}

export function block_markdown() {

	return process_scripts( 'markdown' );

}
