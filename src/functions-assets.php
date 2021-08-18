<?php
/**
 * Asset-related functions and filters.
 *
 * This file holds some setup actions for scripts and styles as well as a helper
 * functions for work with assets.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks;

use function CXL\Blocks\Layout\Content\get_meta_key;

use Hybrid\App;

/**
 * Enqueue scripts/styles for the editor.
 *
 * @return void
 * @since  2021.01.01
 * @access public
 */
add_action('enqueue_block_editor_assets', function () {

	$deps = [
		'wp-i18n',
		'wp-blocks',
		'wp-dom-ready',
		'wp-edit-post',
		'wp-element',
		'wp-token-list',
	];

	wp_enqueue_script( 'cxl-blocks-editor', asset( 'js/editor.js' ), $deps, null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	$local_vars = [];
	$local_vars['contentLayouts'] =
		[
			'layoutKey' => get_meta_key(),
		];

	$local_vars = 'var cxlBlockSettings = ' . json_encode( $local_vars );

	$local_vars = "/* <![CDATA[ */\n" . $local_vars . "\n/* ]]> */\n";

	wp_add_inline_script( 'cxl-blocks-editor', $local_vars, 'before' );

});

/**
 * Helper function for outputting an asset URL in the plugin. This integrates
 * with Laravel Mix for handling cache busting. If used when you enqueue a script
 * or style, it'll append an ID to the filename.
 *
 * @since  2021.01.01
 * @access public
 * @param  string $path  A relative path/file to append to the `public` folder.
 * @return string
 */
function asset( $path ) {

	// Get the Laravel Mix manifest.
	$manifest = App::resolve( 'cxl/blocks/mix' );

	// Make sure to trim any slashes from the front of the path.
	$path = '/' . ltrim( $path, '/' );

	if ( $manifest && isset( $manifest[ $path ] ) ) {
		$path = $manifest[ $path ];
	}

	return plugins_url( 'public' . $path, CXL_BLOCKS_PLUGIN_FILE );
}
