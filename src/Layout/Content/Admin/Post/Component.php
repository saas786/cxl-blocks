<?php
/**
 * Post layout content Component.
 *
 * dds a layout selector to the create and edit post admin screen.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks\Layout\Content\Admin\Post;

use CXL\Blocks\Layout\Content\Layouts;
use CXL\Blocks\Layout\Content as ContentLayout;
use Hybrid\Support\Contracts\Bootable;

use function CXL\Blocks\Layout\Content\get_post_layout;
use function CXL\Blocks\Layout\Content\Admin\form_field_layout;
use function CXL\Blocks\Layout\Content\Admin\verify_nonce_post;

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
	 * Sets up post layout filters.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Load on the edit tags screen.
		add_action( 'add_meta_boxes', [ $this, 'addMetaBoxes' ] );

		// Update post meta.
		add_action( 'save_post', [ $this, 'save' ], 10, 2 );
		add_action( 'add_attachment', [ $this, 'save' ] );
		add_action( 'edit_attachment', [ $this, 'save' ] );
	}

	/**
	 * Runs on the load hook and sets up what we need.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $post_type
	 * @return void
	 */
	public function addMetaBoxes( $post_type ) {

		if ( ! $this->isSupported() ) {
			return;
		}

		if ( post_type_supports( $post_type, 'content-layouts' ) && current_user_can( 'edit_theme_options' ) ) {

			// Add meta box.
			add_meta_box(
				'hybrid-post-layout',
				esc_html__( 'Layout', 'cxl-blocks' ),
				[ $this, 'metaBox' ],
				$post_type,
				'side',
				'default',
				[ '__back_compat_meta_box' => true, ]
			);
		}
	}

	/**
	 * Callback function for displaying the layout meta box.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $post
	 * @param  array  $box
	 * @return void
	 */
	public function metaBox( $post, $box ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedParameter

		// Get only the post layouts.
		$layouts = wp_list_filter( $this->layouts->all(), [
			'is_post_layout' => true,
		] );

		// Remove unwanted layouts.
		foreach ( $layouts as $layout ) {
			// phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
			if ( $layout->post_types && ! in_array( $post->post_type, $layout->post_types ) ) {
				unset( $layouts[ $layout->name ] );
			}
		}

		// Get the current post's layout.
		$post_layout = get_post_layout( $post->ID );

		// Output the nonce field.
		wp_nonce_field( basename( __FILE__ ), 'hybrid_post_layout_nonce' );

		// Output the layout field.
		form_field_layout( [
			'layouts'    => $layouts,
			'selected'   => $post_layout ?: 'default',
			'field_name' => 'hybrid-post-layout',
		] );
	}

	/**
	 * Saves the post layout when submitted via the layout meta box.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int           $post_id
	 * @param  object|string $post
	 * @return void
	 */
	public function save( $post_id, $post = '' ) {

		if ( ! $this->isSupported() ) {
			return;
		}

		// Fix for attachment save issue in WordPress 3.5. @link http://core.trac.wordpress.org/ticket/21963 .
		if ( ! is_object( $post ) ) {
			$post = get_post();
		}

		// Verify the nonce for the post formats meta box.
		if ( ! verify_nonce_post( basename( __FILE__ ), 'hybrid_post_layout_nonce' ) ) {
			return;
		}

		// Get the previous post layout.
		$meta_value = get_post_layout( $post_id );

		// Get the submitted post layout.
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$new_meta_value = isset( $_POST['hybrid-post-layout'] ) ? sanitize_key( $_POST['hybrid-post-layout'] ) : '';

		// If there is no new meta value but an old value exists, delete it.
		// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
		if ( '' == $new_meta_value && $meta_value ) {

			ContentLayout\delete_post_layout( $post_id );

			// If a new meta value was added and there was no previous value, add it.
		} elseif ( $meta_value !== $new_meta_value ) {

			ContentLayout\set_post_layout( $post_id, $new_meta_value );
		}
	}

	/**
	 * Checks whether post term supports content layout.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return bool
	 */
	protected function isSupported() {

		$support = get_theme_support( 'content-layouts' );

		// No support for feature.
		if ( ! $support ) {
			return false;
		}

		// No args passed in to add_theme_support(), so accept none.
		if ( ! isset( $support[0] ) ) {
			return false;
		}

		// Support for specific arg found.
		if ( in_array( 'post_meta', $support[0] ) ) {
			return true;
		}

		return false;
	}
}
