<?php
/**
 * Layout service provider.
 *
 * This is the service provider for the Layout system, which binds an
 * empty collection to the container that can later be used to store layout.
 *
 * @package ConversionXL
 */

namespace CXL\Blocks\Layout;

use CXL\Blocks\Tools\ServiceProvider;
use Hybrid\Support\Tools\Collection;

use CXL\Blocks\Layout\Content;

/**
 * Layout service provider.
 *
 * @since  2021.01.08
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * @inheritDoc
	 */
	public function register(): void {

		$this->cxl_blocks->singleton( 'cxl/blocks/layouts/content', Content\Layouts::class );

		$this->cxl_blocks->singleton( Content\Component::class, function() {

			return new Content\Component( $this->cxl_blocks->resolve( 'cxl/blocks/layouts/content' ) );
		} );

		$this->cxl_blocks->singleton( Content\Admin\Post\Component::class, function() {

			return new Content\Admin\Post\Component( $this->cxl_blocks->resolve( 'cxl/blocks/layouts/content' ) );
		} );

		$this->cxl_blocks->singleton( Content\Admin\Term\Component::class, function() {

			return new Content\Admin\Term\Component( $this->cxl_blocks->resolve( 'cxl/blocks/layouts/content' ) );
		} );

		$this->cxl_blocks->singleton( Content\Block\Component::class, function() {

			return new Content\Block\Component( $this->cxl_blocks->resolve( 'cxl/blocks/layouts/content' ) );
		} );
	}

	/**
	 * @inheritDoc
	 */
	public function boot(): void {

		$this->cxl_blocks->resolve( Content\Component::class )->boot();
		$this->cxl_blocks->resolve( Content\Block\Component::class )->boot();

		if ( is_admin() ) {

			$this->cxl_blocks->resolve( Content\Admin\Post\Component::class )->boot();
			$this->cxl_blocks->resolve( Content\Admin\Term\Component::class )->boot();
		}
	}
}
