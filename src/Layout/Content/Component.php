<?php
/**
 * Layout Component.
 *
 * Manages the layout component.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks\Layout\Content;

use Hybrid\Support\Contracts\Bootable;

use function CXL\Blocks\get_config;

/**
 * Layout component class.
 *
 * @since  2021.01.18
 * @access public
 */
class Component implements Bootable {

	/**
	 * Stores the layouts object.
	 *
	 * @since  2021.01.18
	 * @access protected
	 * @var    Layouts
	 */
	protected $layouts;

	/**
	 * Creates the component object.
	 *
	 * @since  2021.01.18
	 * @access public
	 * @param  Layouts $layouts
	 * @return void
	 */
	public function __construct( Layouts $layouts ) {
		$this->layouts = $layouts;
	}

	/**
	 * Bootstraps the component.
	 *
	 * @since  2021.01.18
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Run registration on `after_setup_theme`.
		add_action( 'after_setup_theme', [ $this, 'register' ] );

		// Register default layouts.
		add_action( 'cxl/blocks/layout/content/register', [ $this, 'registerDefaultLayouts' ] );

		// Filters `current_theme_supports( 'content-layouts', $arg )`.
		add_filter( 'current_theme_supports-content-layouts', [ $this, 'layoutsSupport' ], 10, 3 );

		// Filters the theme layout.
		add_filter( 'cxl/blocks/layout/content/get/content/layout', [ $this, 'filterLayout' ], ~PHP_INT_MAX );

		// Add extra support for post types.
		add_action( 'init', [ $this, 'postTypeSupport' ], 15 );

		// Filters the WordPress element classes.
		add_filter( 'body_class', [ $this, 'bodyClassFilter' ], 10, 2 ); // ~PHP_INT_MAX
	}

	/**
	 * Runs the register actions.
	 *
	 * @since  2021.01.18
	 * @access public
	 * @return void
	 */
	public function register() {

		// Hook for registering custom layouts.
		do_action( 'cxl/blocks/layout/content/register', $this->layouts );
	}

	/**
	 * Registers default loop layouts.
	 *
	 * @since  2021.01.18
	 * @access public
	 * @param  Layouts $layouts
	 * @return void
	 */
	public function registerDefaultLayouts( $layouts ) {

		foreach ( get_config( 'content-layouts' ) as $name => $options ) {
			$layouts->add( $name, new Layout( $name, $options ) );
		}
	}

	/**
	 * Filter on `current_theme_supports-content-layouts` for checking whether a theme
	 * supports a particular feature for content layouts.
	 *
	 * @since  2021.01.18
	 * @access public
	 * @param  bool  $supports
	 * @param  array $args
	 * @param  array $feature
	 * @return bool
	 */
	public function layoutsSupport( $supports, $args, $feature ) {

		// phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
		if ( isset( $args[0] ) && in_array( $args[0], [ 'post_meta', 'term_meta' ] ) ) {

			if ( is_array( $feature[0] ) && isset( $feature[0][ $args[0] ] ) && false === $feature[0][ $args[0] ] ) {
				$supports = false;
			}
		}

		return $supports;
	}

	/**
	 * Default filter on the `cxl/blocks/layout/content/get/content/layout` hook.  By default, we'll
	 * check for per-post or per-author layouts saved as metadata.  If set, we'll
	 * filter.  Else, just return the global layout.
	 *
	 * @since  2021.01.18
	 * @access public
	 * @param  string $theme_layout
	 * @return string
	 */
	public function filterLayout( $theme_layout ) {

		$layout = '';

		// If viewing a singular post, get the post layout.
		if ( is_singular() ) {
			$layout = get_post_layout( get_queried_object_id() );

			// If viewing an author archive, get the user layout.
		} elseif ( is_author() ) {
			$layout = get_user_layout( get_queried_object_id() );

			// If viewing a term archive, get the term layout.
		} elseif ( is_tax() || is_category() || is_tag() ) {
			$layout = get_term_layout( get_queried_object_id() );
		}

		return $layout && layout_exists( $layout ) && 'default' !== $layout ? $layout : $theme_layout;
	}

	/**
	 * This function is for adding extra support for features not default to the core post types.
	 * Excerpts are added to the 'page' post type.  Comments and trackbacks are added for the
	 * 'attachment' post type.  Technically, these are already used for attachments in core, but
	 * they're not registered.
	 *
	 * @since 2021.01.18
	 * @access public
	 * @return void
	 */
	public function postTypeSupport() {

		// Add theme layouts support to core and custom post types.
		array_map(
			function( $type ) {
				add_post_type_support( $type, 'content-layouts' );
			},
			[
				'post',
				'page',
				'attachment',
			]
		);
	}

	/**
	 * Filters the WordPress body class with a better set of classes that are more
	 * consistently handled and are backwards compatible with the original body
	 * class functionality that existed prior to WordPress core adopting this feature.
	 *
	 * @since  2021.01.18
	 * @access public
	 * @param  array $classes
	 * @param  array $class
	 * @return array
	 */
	public function bodyClassFilter( $classes, $class ) {

		// Theme layouts.
		if ( current_theme_supports( 'content-layouts' ) ) {
			$classes[] = sanitize_html_class( 'layout-' . get_content_layout() );
		}

		/**
		 * @psalm-suppress RedundantCastGivenDocblockType
		 */
		return array_map( 'esc_attr', array_unique( array_merge( $classes, (array) $class ) ) );
	}
}
