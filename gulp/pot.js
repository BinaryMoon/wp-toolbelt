/* jshint esnext: true */
'use strict';

const gulp = require( 'gulp' );
const wpPot = require( 'gulp-wp-pot' );

export default function translate() {

	return gulp.src( '**/*.php' )
		.pipe(
			wpPot(
				{
					domain: 'wp-toolbelt',
					package: 'Toolbelt'
				}
			)
		)
		.pipe( gulp.dest( './languages/wp-toolbelt.pot' ) );

}
