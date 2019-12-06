/* jshint esnext: true */
'use strict';

const gulp = require( 'gulp' );
const download = require( 'gulp-download' );
const plumber = require( 'gulp-plumber' );
const rename = require( 'gulp-rename' );

export default function update_blocklist() {

	const blacklist_url = 'https://raw.githubusercontent.com/splorp/wordpress-comment-blacklist/master/blacklist.txt';

	return download( blacklist_url )
		.pipe( rename( 'blocklist.txt' ) )
		.pipe( plumber() )
		.pipe( gulp.dest( './modules/spam-blocker/' ) );

}
