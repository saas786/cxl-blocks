<?php
/**
 * Layouts API - An API for themes to build layout options.
 *
 * Theme Layouts was created to allow theme developers to easily style themes
 * with dynamic layout structures. This file merely contains the API function
 * calls at theme developers' disposal.
 *
 * @package ConversionXL
 */

namespace CXL\Blocks\Layout\Content;

use Hybrid\App;

/**
 * Returns an instance of a layouts Collection.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function layouts() {
	return App::resolve( 'cxl/blocks/layouts/content' );
}

/**
 * Checks if a layout exists.
 *
 * @since  1.0.0
 * @access public
 * @param  string $name
 * @return bool
 */
function layout_exists( $name ) {

	return layouts()->has( $name );
}

/**
 * Returns an array of registered layout objects.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function get_layouts() {

	return layouts()->all();
}

/**
 * Gets the theme layout.  This is the global theme layout defined. Other
 * functions filter the available `theme_mod_theme_layout` hook to overwrite this.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function get_content_layout() {

	return apply_filters( 'cxl/blocks/layout/content/get/content/layout', get_default_layout() );
}

/**
 * Returns the default layout defined by in the config.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function get_default_layout() {
	$default = 'no-default-layout';

	foreach ( get_layouts() as $layout ) {
		if ( $layout->is_default ) {
			$default = $layout->name;
			break;
		}
	}

	return $default;
}

/**
 * Gets a post layout.
 *
 * @since  1.0.0
 * @access public
 * @param  int $post_id
 * @return string
 */
function get_post_layout( $post_id ) {

	return get_object_layout( 'post', $post_id );
}

/**
 * Sets a post layout.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $post_id
 * @param  string $layout
 * @return bool
 */
function set_post_layout( $post_id, $layout ) {

	return set_object_layout( 'post', $post_id, $layout );
}

/**
 * Deletes a post layout.
 *
 * @since  1.0.0
 * @access public
 * @param  int $post_id
 * @return bool
 */
function delete_post_layout( $post_id ) {

	return delete_object_layout( 'post', $post_id );
}

/**
 * Checks a post if it has a specific layout.
 *
 * @since  1.0.0
 * @access public
 * @param  string|null $layout
 * @param  int|string  $post_id
 * @return bool
 */
function has_post_layout( $layout, $post_id = '' ) {

	// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison,WordPress.PHP.YodaConditions.NotYoda
	return $layout == get_post_layout( $post_id ?: get_the_ID() );
}

/**
 * Gets a term layout.
 *
 * @since  1.0.0
 * @access public
 * @param  int $term_id
 * @return string
 */
function get_term_layout( $term_id ) {

	return get_object_layout( 'term', $term_id );
}

/**
 * Sets a term layout.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $term_id
 * @param  string $layout
 * @return bool
 */
function set_term_layout( $term_id, $layout ) {

	return set_object_layout( 'term', $term_id, $layout );
}

/**
 * Deletes a term layout.
 *
 * @since  1.0.0
 * @access public
 * @param  int $term_id
 * @return bool
 */
function delete_term_layout( $term_id ) {

	return delete_object_layout( 'term', $term_id );
}

/**
 * Checks a term if it has a specific layout.
 *
 * @since  1.0.0
 * @access public
 * @param  string     $layout
 * @param  int|string $term_id
 * @return bool
 */
function has_term_layout( $layout, $term_id = '' ) {

	// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison,WordPress.PHP.YodaConditions.NotYoda
	return $layout == get_term_layout( $term_id ?: get_queried_object_id() );
}

/**
 * Wrapper function for returning the metadata key used for objects that can
 * use layouts.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function get_meta_key() {

	return apply_filters( 'cxl/blocks/layout/content/meta/key', 'Layout' );
}

/**
 * Helper function for getting an object layout.
 *
 * @since  1.0.0
 * @access public
 * @param  string $meta_type
 * @param  int    $object_id
 * @return string
 */
function get_object_layout( $meta_type, $object_id ) {

	return get_metadata( $meta_type, $object_id, get_meta_key(), true );
}

/**
 * Helper function for setting an object layout.
 *
 * @since  1.0.0
 * @access public
 * @param  string $meta_type
 * @param  int    $object_id
 * @param  string $layout
 * @return bool
 */
function set_object_layout( $meta_type, $object_id, $layout ) {

	return 'default' !== $layout
			? update_metadata( $meta_type, $object_id, get_meta_key(), $layout )
			: delete_object_layout( $meta_type, $object_id );
}

/**
 * Helper function for deleting an object layout.
 *
 * @since  1.0.0
 * @access public
 * @param  string $meta_type
 * @param  int    $object_id
 * @return bool
 */
function delete_object_layout( $meta_type, $object_id ) {

	return delete_metadata( $meta_type, $object_id, get_meta_key() );
}
