<?php
/**
 * Content Layout component.
 *
 * Handles the content layout feature.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks\Layout\Content\Block;

use Hybrid\Contracts\Bootable;
use CXL\Blocks\Layout\Content\Layouts;

use function CXL\Blocks\Layout\Content\get_meta_key;

/**
 * Content layout component class.
 *
 * @since  2021.01.05
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
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {

		add_action( 'rest_api_init', [ $this, 'registerLayouts' ] );
		add_action( 'init', [ $this, 'registerMeta' ] );
	}

	/**
	 * Add `layouts` endpoint to the REST API.
	 *
	 * Example: `curl https://example.com/wp-json/cxlblocks/v1/layouts/site`
	 * Example: `curl https://example.com/wp-json/cxlblocks/v1/layouts/singular,page,24`
	 *
	 * @since 1.0.0 Accept multiple comma-separated layout types.
	 *              Types are checked from right to left, returning the first type
	 *              with registered layouts and falling back to 'site' if no passed
	 *              types have registered layouts.
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function registerLayouts() {

		\register_rest_route(
			'cxlblocks/v1',
			'/layouts/(?P<type>[a-z0-9,_-]+)',
			[
				'methods'             => 'GET',
				'callback'            => function( $params ) {
					$type = $params['type'];
					if ( strpos( $type, ',' ) !== false ) {
						$type = explode( ',', $type );
					}
					return $this->getLayouts( $type );
				},
				'permission_callback' => '__return_true',
			]
		);
	}

	/**
	 * Return all content layouts.
	 *
	 * @since 1.0.0
	 *
	 * @param array|string $type Layout type to return. Leave empty to return default layouts. For arrays, types are checked
	 *                           from right to left, returning the first type with registered layouts and falling back to
	 *                           'site' if no passed types have registered layouts. If the final array value is numeric, the
	 *                           second value from the end is assumed to be a post type, such as 'post' or 'page' and the
	 *                           layout specific to that page or post ID would be registered as 'post-123' or 'page-123'.
	 *                           - Example 1, default layouts: `getLayouts();`
	 *                           - Example 2, 'page-123', 'page', 'singular', then 'site':
	 *                             `getLayouts( [ 'singular', get_post_type(), get_the_ID() ] );`.
	 * @return array Registered layouts.
	 */
	public function getLayouts( $type = 'site' ) {

		$content_layouts = $this->layouts->all();

		// If no layouts exists, return empty array.
		if ( ! is_array( $content_layouts ) ) {
			return [];
		}

		$layouts = [];

		$types = array_reverse( (array) $type );

		// Default fallback is site.
		$types[] = 'site';

		if ( is_numeric( $types[0] ) ) {
			$id       = $types[0];
			$types[0] = $types[1] . '-' . $types[0];
		}

		// Cycle through looking for layouts of $type.
		foreach ( $types as $type ) {
			foreach ( $content_layouts as $id => $data ) {
				$data = (array) $data;
				if ( in_array( $type, $data['type'], true ) ) {
					$layouts[ $id ] = $data;
				}
			}

			if ( $layouts ) {
				break;
			}
		}

		return $layouts;
	}

	/**
	 * Register post meta for CXL Blocks Block Editor features,
	 * such as the content layout.
	 *
	 * Meta must be registered to allow getting and setting via the REST API.
	 *
	 * Protecting fields by prefixing them with an underscore prevents them from
	 * appearing in the Custom Fields meta box, where they would override changes
	 * to the Block Editor Redux store.
	 *
	 * Passing '__return_true' for `auth_callback` allows the field to be updated
	 * via the REST API even though it is protected.
	 *
	 * @since 2021.01.06
	 */
	public function registerMeta() {
		$args = [
			'auth_callback' => '__return_true',
			'type'          => 'string',
			'single'        => true,
			'show_in_rest'  => true,
		];

		$string_args = array_merge( $args, [ 'type' => 'string' ] );

		// Layout: string layout.
		register_meta( 'post', get_meta_key(), $string_args );
	}
}
