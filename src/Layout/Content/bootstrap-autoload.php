<?php
/**
 * Autoload layout bootstrap file.
 *
 * This file is used to autoload classes and functions necessary for the layout
 * to run. Classes utilize the PSR-4 autoloader in Composer which is defined in
 * `composer.json`.
 *
 * @package ConversionXL
 */

// ------------------------------------------------------------------------------
// Autoload Layout functions files.
// ------------------------------------------------------------------------------
//
// Load any functions-files from the `/src/Layout/Content` folder that are needed. Add additional
// files to the array without the `.php` extension.

array_map(
	function( $file ) {
		/**
		 * @psalm-suppress UnresolvableInclude
		 */
		require_once CXL_BLOCKS_PLUGIN_DIR . "/src/Layout/Content/{$file}.php";
	},
	[
		'Admin/functions-meta',
		'Admin/functions-admin',
		'functions-layouts',
	]
);
