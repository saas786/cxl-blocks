<?php
/**
 * Metadata functions.
 *
 * Metadata functions used in the core framework.  This file registers meta keys
 * for use in WordPress in a safe manner by setting up a custom sanitize callback.
 *
 * @package ConversionXL
 */

namespace CXL\Blocks\Layout\Content\Admin;

use function CXL\Blocks\Layout\Content\get_meta_key;

// Register meta on the 'init' hook.
add_action( 'init', __NAMESPACE__ . '\register_meta', 15 );

/**
 * Registers the framework's custom metadata keys and sets up the sanitize
 * callback function.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function register_meta() {

	// Theme layouts meta.
	if ( current_theme_supports( 'content-layouts' ) ) {

		array_map( function( $type ) {

			\register_meta( $type, get_meta_key(), [
				'type'              => 'string',
				'single'            => true,
				'sanitize_callback' => 'sanitize_key',
				'auth_callback'     => function() {
					return '__return_false';
				},
				'show_in_rest'      => true,
			] );

		}, [ 'post', 'term' ] );
	}
}
