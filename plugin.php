<?php
/**
 * CXL Blocks
 *
 * @package ConversionXL
 *
 * Plugin Name: CXL Blocks
 * Plugin URI: https://cxl.com/
 * Description: CXL Blocks
 * Author: Leho Kraav
 * Author URI: https://cxl.com
 * Version: 2021.01.01
 */

use CXL\Blocks\Plugin;

defined( 'ABSPATH' ) || exit;

define( 'CXL_BLOCKS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CXL_BLOCKS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CXL_BLOCKS_PLUGIN_FILE', __FILE__ );
define( 'CXL_BLOCKS_PLUGIN_BASE', plugin_basename( __FILE__ ) );

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Returns plugin instance.
 *
 * @return Plugin
 * @since 2021.01.01
 */
function cxl_blocks() {

	return Plugin::getInstance();

}

add_action( 'plugins_loaded', 'cxl_blocks', 2 );
