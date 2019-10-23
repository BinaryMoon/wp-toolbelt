/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const rename = require( 'gulp-rename' );
const uglify = require( 'gulp-uglify' );
const size = require( 'gulp-filesize' );
const babel = require( 'gulp-babel' );
const include = require( 'gulp-include' );


function process_scripts( slug ) {

	const destination = './modules/' + slug + '/';
	const source = './modules/' + slug + '/src/block/block.js';
	const env = [
		'@babel/preset-env',
		'@wordpress/babel-preset-default'
	];

	return src( source )
		.pipe(
			include(
				{
					includePaths: [
						__dirname + '/../node_modules',
					]
				}
			)
		)
		.pipe(
			babel( { presets: env } )
		)
		.pipe(
			uglify()
		)
		.pipe( rename( 'block.min.js' ) )
		.pipe( dest( destination ) )
		.pipe( size() );

}

export function block_markdown() {

	return process_scripts( 'markdown' );

}

export function block_testimonials() {

	return process_scripts( 'testimonials' );

}

export function block_projects() {

	return process_scripts( 'projects' );

}
