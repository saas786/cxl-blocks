<?php
/**
 * Layout.
 *
 * Creates a layout object.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks\Layout;

/**
 * Layout class.
 *
 * @since  2021.01.08
 * @access public
 */
class Layout {

	/**
	 * Setting name.
	 *
	 * @since  2021.01.08
	 * @access protected
	 * @var    string
	 */
	protected $name;

	/**
	 * Setting label.
	 *
	 * @since  2021.01.08
	 * @access protected
	 * @var    string
	 */
	protected $label;

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

		foreach ( array_keys( get_object_vars( $this ) ) as $key ) {
			if ( isset( $options[ $key ] ) ) {
				$this->$key = $options[ $key ];
			}
		}

		$this->name = $name;
	}

	/**
	 * Returns the choice name.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @return string
	 */
	public function name() {
		return $this->name;
	}

	/**
	 * Returns the choice label.
	 *
	 * @since  2021.01.08
	 * @access public
	 * @return string
	 */
	public function label() {

		return apply_filters(
			"cxl/blocks/layout/{$this->name}/label",
			$this->label ?: $this->name(),
			$this
		);
	}
}
