/* jshint esnext: true */
'use strict';

// External dependencies.
import { series, parallel, watch } from 'gulp';

import { styles_cookie, styles_social } from './gulp/sass';
import scripts from './gulp/script';

export const build = parallel(
	styles_cookie,
	styles_social,
	scripts
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

