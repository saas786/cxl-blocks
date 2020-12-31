<?php
/**
 * Content Layout.
 *
 * Creates a layout object for the loop content area.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks\Layout\Content;

use CXL\Blocks\Layout\Layout as Base;

/**
 * Loop layout class.
 *
 * @since  2021.01.08
 * @access public
 */
class Layout extends Base {

	/**
	 * Whether this layout is fallback / default layout?.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @var    bool
	 */
	public $is_default = false;

	/**
	 * Whether to show as an option in the post meta box.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @var    bool
	 */
	public $is_post_layout = true;

	/**
	 * Whether to show as an option on taxonomy term pages.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @var    bool
	 */
	public $is_term_layout = true;

	/**
	 * Internationalized text label.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @var    string
	 */
	public $label = '';

	/**
	 * Internationalized text name.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @var    string
	 */
	public $name = '';

	/**
	 * Array of post types layout works with.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @var    array
	 */
	public $post_types = [];

	/**
	 * Array of type (post, term or site) layout works with.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @var    array
	 */
	public $type = [];

	/**
	 * Array of taxonomies layout works with.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @var    bool|array
	 */
	public $taxonomies = [];

	/**
	 * Internal use only! Whether the layout is built in.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @var    bool
	 */
	public $_builtin = false; // phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore

	/**
	 * Internal use only! Whether the layout is internal (cannot be unregistered).
	 *
	 * @since  2021.01.08
	 * @access public
	 * @var    bool
	 */
	public $_internal = false; // phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore

	/* ====== Magic Methods ====== */

	/**
	 * Don't allow properties to be unset.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @param  string $property
	 * @return void
	 */
	public function __unset( $property ) {} // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedParameter

	/**
	 * Magic method to use in case someone tries to output the layout object
	 * as a string. We'll just return the layout name.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @return string
	 */
	public function __toString() {

		return $this->name;
	}

	/**
	 * Set up the object properties.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @param  string $name
	 * @param  array  $options
	 * @return void
	 */
	public function __construct( $name, array $options = [] ) {
		parent::__construct( $name, $options );

		$this->addPostTypeSupport();
	}

	/* ====== Protected Methods ====== */

	/**
	 * Adds post type support for `content-layouts` in the event that the
	 * layout has been explicitly set for one or more post types.
	 *
	 * @todo   Ideally, this should be moved out of the class.
	 * @since  2021.01.08
	 * @access protected
	 * @return void
	 */
	protected function addPostTypeSupport() {

		if ( $this->post_types ) {

			foreach ( $this->post_types as $post_type ) {

				if ( ! post_type_supports( $post_type, 'content-layouts' ) ) {
					add_post_type_support( $post_type, 'content-layouts' );
				}
			}
		}
	}
}
