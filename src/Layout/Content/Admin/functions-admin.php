<?php
/**
 * Admin functions.
 *
 * Theme administration functions used with other components of the framework
 * admin. This file is for setting up any basic features and holding additional
 * admin helper functions.
 *
 * @package ConversionXL
 */

namespace CXL\Blocks\Layout\Content\Admin;

use function CXL\Blocks\Layout\Content\get_layouts;

// Allow posts page to be edited.
add_action( 'edit_form_after_title', __NAMESPACE__ . '\enable_posts_page_editor', 0 );

/**
 * Fix for users who want to display content on the posts page above the posts
 * list, which is a theme feature common to themes built from the framework.
 *
 * @since  1.0.0
 * @access public
 * @param  object $post
 * @return void
 */
function enable_posts_page_editor( $post ) {

	// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
	if ( get_option( 'page_for_posts' ) != $post->ID ) {
		return;
	}

	remove_action( 'edit_form_after_title', '_wp_posts_page_notice' );
	add_post_type_support( $post->post_type, 'editor' );
}

/**
 * Wrapper function for `wp_verify_nonce()` with a posted value.
 *
 * @since  1.0.0
 * @access public
 * @param  string $action
 * @param  string $arg
 * @return bool
 */
function verify_nonce_post( $action = '', $arg = '_wpnonce' ) {

	return isset( $_POST[ $arg ] )
			? wp_verify_nonce( sanitize_key( $_POST[ $arg ] ), $action )
			: false;
}

/**
 * Wrapper function for `wp_verify_nonce()` with a request value.
 *
 * @since  1.0.0
 * @access public
 * @param  string $action
 * @param  string $arg
 * @return bool
 */
function verify_nonce_request( $action = '', $arg = '_wpnonce' ) {

	return isset( $_REQUEST[ $arg ] )
			? wp_verify_nonce( sanitize_key( $_REQUEST[ $arg ] ), $action )
			: false;
}

/**
 * Displays the layout form field.  Used for various admin screens.
 *
 * @since  1.0.0
 * @access public
 * @param  array $args
 * @return void
 */
function form_field_layout( $args = [] ) {

	$args = wp_parse_args( $args, [
		'layouts'    => get_layouts(),
		'selected'   => 'default',
		'field_name' => 'hybrid-layout',
	] ); ?>

	<div class="hybrid-form-field-layout">
		<select class="widefat" name="<?php echo esc_attr( $args['field_name'] ); ?>">
		<?php foreach ( $args['layouts'] as $layout ) : ?>
			<option value="<?php echo esc_attr( $layout->name ); ?>" <?php selected( $args['selected'], $layout->name ); ?>>
				<?php echo esc_attr( $layout->label ); ?>
			</option>
		<?php endforeach; ?>
		</select>

	</div>
	<?php
}
