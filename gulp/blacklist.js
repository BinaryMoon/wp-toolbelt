/* jshint esnext: true */
'use strict';

const gulp = require( 'gulp' );
const download = require( 'gulp-download' );
const plumber = require( 'gulp-plumber' );

export default function update_blacklist() {

	const blacklist_url = 'https://raw.githubusercontent.com/splorp/wordpress-comment-blacklist/master/blacklist.txt';

	return download( blacklist_url )
		.pipe( plumber() )
		.pipe( gulp.dest( './modules/spam-blocker/' ) );

}
