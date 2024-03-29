<?php
/**
 * Layouts Collection.
 *
 * Houses the collection of layouts in a single array-object.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks\Layout;

use Hybrid\Tools\Collection;

/**
 * Layouts class.
 *
 * @since  2021.01.18
 * @access public
 */
class Layouts extends Collection {

	/**
	 * Adds a new layout to the collection.
	 *
	 * @since  2021.01.18
	 * @access public
	 * @param  string $name
	 * @param  array  $value
	 * @return void
	 */
	public function add( $name, $value ) {

		parent::add(
			$name,
			$value instanceof Layout ? $value : new Layout( $name, $value )
		);
	}
}
