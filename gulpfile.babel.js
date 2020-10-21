/* jshint esnext: true */
'use strict';

/**
 * External dependencies.
 */
import {
	series,
	parallel,
	watch
} from 'gulp';

import {
	process_global_styles,
	process_module_styles,
	process_block_styles
} from './gulp/sass';

import {
	process_module_scripts
} from './gulp/script';

import {
	process_block_scripts
} from './gulp/script-block';

import update_blocklist from './gulp/blocklist';

import compress from './gulp/zip';

import translate from './gulp/pot';

import {
	jetpack_stats,
	toolbelt_stats
} from './gulp/stats';


/**
 * Export Gulp tasks.
 */
export const buildTranslations = translate;
export const buildZip = compress;
export const buildblocklist = update_blocklist;
export const buildStats = parallel( jetpack_stats, toolbelt_stats );

export const build = series(
	parallel(
		// Build Styles.
		process_module_styles,
		process_block_styles,
		process_global_styles,

		// Build Scripts.
		process_module_scripts,
		process_block_scripts,

		// Other.
		translate,
		update_blocklist
	),
	compress
);

export const watchFiles = function( done ) {

	watch(
		'./modules/*/src/sass/**/*.scss',
		process_module_styles
	);

	watch(
		'./modules/*/src/block/*.scss',
		process_block_styles
	);

	watch(
		[ './modules/*/src/js/*.js' ],
		process_module_scripts
	);

	watch(
		[
			'./modules/*/src/block/*.js',
			'./modules/*/src/block/**/*.js'
		],
		process_block_scripts,
	);

	watch(
		[ './assets/sass/*.scss' ],
		process_global_styles
	);

	done();

};

export default series(
	build,
	watchFiles
);

