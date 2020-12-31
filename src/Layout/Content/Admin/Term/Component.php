<?php
/**
 * Term Layout Content Component.
 *
 * Adds a layout selector to the create and edit term admin screen.
 *
 * @package   CXL Blocks
 */

namespace CXL\Blocks\Layout\Content\Admin\Term;

use CXL\Blocks\Layout\Content\Layouts;
use CXL\Blocks\Layout\Content as ContentLayout;
use Hybrid\Support\Contracts\Bootable;

use function CXL\Blocks\Layout\Content\get_term_layout;
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
	 * Sets up term layout filters.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Load on the edit tags screen.
		add_action( 'load-tags.php', [ $this, 'load' ] );
		add_action( 'load-edit-tags.php', [ $this, 'load' ] );

		// Update term meta.
		add_action( 'create_term', [ $this, 'save' ] );
		add_action( 'edit_term', [ $this, 'save' ] );
	}

	/**
	 * Runs on the load hook and sets up what we need.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function load() {

		if ( ! $this->isSupported() ) {
			return;
		}

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		$screen = get_current_screen();

		// Add the form fields.
		add_action( "{$screen->taxonomy}_add_form_fields", [ $this, 'addFormFields' ] );
		add_action( "{$screen->taxonomy}_edit_form_fields", [ $this, 'editFormFields' ] );
	}

	/**
	 * Displays the layout selector in the new term form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function addFormFields() { ?>

		<div class="form-field hybrid-term-layout-wrap">

			<p class="hybrid-term-layout-header"><?php esc_html_e( 'Layout', 'cxl-blocks' ); ?></p>

			<?php $this->displayField(); ?>

		</div>
		<?php
	}

	/**
	 * Displays the layout selector on the edit term screen.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object|string $term
	 * @return void
	 */
	public function editFormFields( $term ) {
		?>

		<tr class="form-field hybrid-term-layout-wrap">

			<th scope="row"><?php esc_html_e( 'Layout', 'cxl-blocks' ); ?></th>

			<td><?php $this->displayField( $term ); ?></td>
		</tr>
		<?php
	}

	/**
	 * Function for outputting the radio image input fields.
	 *
	 * Note that this will most likely be deprecated in the future in favor
	 * of building an all-purpose field to be used in any form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object|string $term
	 * @return void
	 */
	public function displayField( $term = '' ) {

		$term_layout = 'default';
		$taxonomy    = get_current_screen()->taxonomy;

		// Get only the term layouts.
		$layouts = wp_list_filter( $this->layouts->all(), [
			'is_term_layout' => true,
		] );

		// Remove unwanted layouts.
		foreach ( $layouts as $layout ) {
			// phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
			if ( $layout->taxonomies && ! in_array( $taxonomy, $layout->taxonomies ) ) {
				unset( $layouts[ $layout->name ] );
			}
		}

		// If we have a term, get its layout.
		if ( $term ) {
			/**
			 * @psalm-suppress PossiblyInvalidPropertyFetch
			 */
			$term_layout = get_term_layout( $term->term_id );
		}

		// Output the nonce field.
		wp_nonce_field( basename( __FILE__ ), 'hybrid_term_layout_nonce' );

		// Output the layout field.
		form_field_layout( [
			'layouts'    => $layouts,
			'selected'   => $term_layout ? $term_layout : 'default',
			'field_name' => 'hybrid-term-layout',
		] );
	}

	/**
	 * Saves the term meta.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int $term_id
	 * @return void
	 */
	public function save( $term_id ) {

		if ( ! $this->isSupported() ) {
			return;
		}

		if ( ! verify_nonce_post( basename( __FILE__ ), 'hybrid_term_layout_nonce' ) ) {
			return;
		}

		$old_layout = get_term_layout( $term_id );
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$new_layout = isset( $_POST['hybrid-term-layout'] ) ? sanitize_key( $_POST['hybrid-term-layout'] ) : '';

		if ( $old_layout && '' === $new_layout ) {

			ContentLayout\delete_term_layout( $term_id );

		} elseif ( $old_layout !== $new_layout ) {

			ContentLayout\set_term_layout( $term_id, $new_layout );
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
		if ( in_array( 'term_meta', $support[0] ) ) {
			return true;
		}

		return false;
	}
}
