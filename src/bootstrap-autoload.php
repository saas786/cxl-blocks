<?php
/**
 * Autoload bootstrap file.
 *
 * This file is used to autoload classes and functions necessary for the plugin
 * to run. Classes utilize the PSR-4 autoloader in Composer which is defined in
 * `composer.json`.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks;

// ------------------------------------------------------------------------------
// Autoload functions files.
// ------------------------------------------------------------------------------
//
// Load any functions-files from the `/app` folder that are needed. Add additional
// files to the array without the `.php` extension.

array_map(
	function( $file ) {
		/**
		 * @psalm-suppress UnresolvableInclude
		 */
		require_once CXL_BLOCKS_PLUGIN_DIR . "/src/{$file}.php"; /** @psalm-suppress UnresolvableInclude */
	},
	[
		'functions-utils',
		'functions-assets',

		'Layout/Content/bootstrap-autoload',
	]
);
