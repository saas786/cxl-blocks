<?php
/**
 * CXL Blocks implementation
 *
 * @package ConversionXL
 */

namespace CXL\Blocks;

use Exception;

defined( 'ABSPATH' ) || exit;

/**
 * Main class
 *
 * @psalm-suppress UndefinedTrait
 */
final class Plugin {

	/**
	 * Plugin dir path.
	 *
	 * @var string
	 */
	public $plugin_dir_path;

	/**
	 * Plugin dir url.
	 *
	 * @var string
	 */
	public $plugin_dir_url;

	/**
	 * Directory slug
	 *
	 * @var string
	 */
	public $slug;

	/**
	 * Singleton pattern
	 *
	 * @var null|Plugin
	 */
	private static $instance;

	/**
	 * Clone
	 */
	private function __clone() {}

	/**
	 * Constructor.
	 *
	 * @throws Exception
	 */
	private function __construct() {

		/**
		 * Provision plugin context info.
		 *
		 * @see https://developer.wordpress.org/reference/functions/plugin_dir_path/
		 * @see https://stackoverflow.com/questions/11094776/php-how-to-go-one-level-up-on-dirname-file
		 */
		$this->plugin_dir_path = trailingslashit( dirname( __DIR__, 1 ) );
		$this->plugin_dir_url  = plugin_dir_url( __FILE__ );
		$this->slug            = basename( $this->plugin_dir_path );

		// Run.
		add_action( 'plugins_loaded', [ $this, 'init' ], 3 );
	}

	/**
	 * Init
	 */
	public function init(): void {
		// ------------------------------------------------------------------------------
		// Bootstrap the plugin.
		// ------------------------------------------------------------------------------
		//
		// Load the bootstrap files. Note that autoloading should happen first so that
		// any classes/functions are available that we might need.

		/**
		 * @psalm-suppress UnresolvableInclude
		 */
		require_once $this->plugin_dir_path . 'src/bootstrap-autoload.php';

		/**
		 * @psalm-suppress UnresolvableInclude
		 */
		require_once $this->plugin_dir_path . 'src/bootstrap-app.php';
	}

	/**
	 * Singleton pattern.
	 */
	public static function getInstance(): Plugin {

		if ( ! self::$instance ) {
			/** @var Plugin $instance */
			self::$instance = new self();
		}

		return self::$instance;

	}

}
