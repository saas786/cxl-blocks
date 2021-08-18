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

use Hybrid\Core\ServiceProvider;
use Hybrid\Tools\Collection;

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

		$this->app->singleton( 'cxl/blocks/layouts/content', Content\Layouts::class );

		$this->app->singleton( Content\Component::class, function() {

			return new Content\Component( $this->app->resolve( 'cxl/blocks/layouts/content' ) );
		} );

		$this->app->singleton( Content\Admin\Post\Component::class, function() {

			return new Content\Admin\Post\Component( $this->app->resolve( 'cxl/blocks/layouts/content' ) );
		} );

		$this->app->singleton( Content\Admin\Term\Component::class, function() {

			return new Content\Admin\Term\Component( $this->app->resolve( 'cxl/blocks/layouts/content' ) );
		} );

		$this->app->singleton( Content\Block\Component::class, function() {

			return new Content\Block\Component( $this->app->resolve( 'cxl/blocks/layouts/content' ) );
		} );
	}

	/**
	 * @inheritDoc
	 */
	public function boot(): void {

		$this->app->resolve( Content\Component::class )->boot();
		$this->app->resolve( Content\Block\Component::class )->boot();

		if ( is_admin() ) {

			$this->app->resolve( Content\Admin\Post\Component::class )->boot();
			$this->app->resolve( Content\Admin\Term\Component::class )->boot();
		}
	}
}
