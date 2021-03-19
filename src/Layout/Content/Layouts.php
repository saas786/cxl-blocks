<?php
/**
 * Content Layouts Collection.
 *
 * Houses the collection of layouts in a single array-object.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks\Layout\Content;

use CXL\Blocks\Layout\Layouts as Base;
use Hybrid\Tools\Collection;

/**
 * Loop Layouts class.
 *
 * @since  2021.01.18
 * @access public
 */
class Layouts extends Base {

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
