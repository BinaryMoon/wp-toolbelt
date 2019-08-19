/* jshint esnext: true */
'use strict';

const { src, dest } = require( 'gulp' );
const zip = require( 'gulp-zip' );

const compress = function() {

	const exclude = [
		'!package.json',
		'!package-lock.json',
		'!gulpfile.babel.js',
		'!modules/**/src/',
		'!modules/**/src/**',
		'!gulp/',
		'!gulp/**',
		'!node_modules/',
		'!node_modules/**',
		'!**/*.scss',
		'!**/*.md',
	];

	// console.log( [ ...exclude, './**' ] );

	return src( [ './**', ...exclude ] )
		.pipe(
			zip( 'wp-toolbelt.zip' )
		)
		.pipe(
			dest( '../.' )
		);

};

export default compress;
