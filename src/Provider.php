<?php
/**
 * App service provider.
 *
 * Service providers are essentially the bootstrapping code for your plugin.
 * They allow you to add bindings to the container on registration and boot them
 * once everything has been registered.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks;

use CXL\Blocks\Tools\ServiceProvider;

/**
 * App service provider.
 *
 * @since  1.0.0
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Callback executed when the `\Hybrid\Core\Application` class registers
	 * providers. Use this method to bind items to the container.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register() {

		$this->cxl_blocks->instance( 'cxl/blocks/path', CXL_BLOCKS_PLUGIN_DIR );

		$this->cxl_blocks->singleton( 'cxl/blocks/mix', function( $app ) {
			$path = $app->resolve( 'cxl/blocks/path' );
			$file = "{$path}/public/mix-manifest.json";

			return file_exists( $file ) ? json_decode( file_get_contents( $file ), true ) : null; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		} );
	}
}
