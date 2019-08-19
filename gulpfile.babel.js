/* jshint esnext: true */
'use strict';

// External dependencies.
import { series, parallel, watch } from 'gulp';

import { styles_cookie, styles_social } from './gulp/sass';
import scripts from './gulp/script';
import compress from './gulp/zip';

export const buildZip = compress;

export const build = series(
	parallel(
		styles_cookie,
		styles_social,
		scripts
	),
	compress
);

export const watchFiles = function( done ) {
	watch(
		'./**/*.scss',
		parallel(
			styles_cookie,
			styles_social
		)
	);
	watch(
		[ './**/*.js', '!./**/script.js', '!./**/script.min.js' ],
		scripts
	);

	done();
};

export default series(
	build,
	watchFiles
);

