/* jshint esnext: true */
'use strict';

// External dependencies.
import { series, watch } from 'gulp';

import styles from './gulp/sass';
import scripts from './gulp/script';

export const build = series(
	styles,
	scripts
);

export const watchFiles = function( done ) {
	watch(
		'./**/*.scss',
		styles
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

