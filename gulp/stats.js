/* jshint esnext: true */
'use strict';

const gulp = require( 'gulp' );
const sloc = require( 'gulp-sloc' );

export function toolbelt_stats() {

	const count_src = [
		'modules/**/*.php',
		'admin/**/*.php',
		'*.php',
		'modules/*/src/**/*.js',
	];

	return gulp.src( count_src )
		.pipe( sloc() );

}

export function jetpack_stats() {

	const count_src = [
		'../jetpack/**/*.php',
		'../jetpack/*.php',
		'../jetpack/**/*.js',
		'!../jetpack/**/*.min.js'
	];

	return gulp.src( count_src )
		.pipe( sloc() );

}
