<?php

namespace CXL\Blocks;

use CXL\CommonLib\Tools\Config\Plugin as Config;
use CXL\Blocks\Proxies\App;

/**
 * Retrieves the config file data.
 *
 * @since 2021.01.05
 *
 * @param  string $name
 * @return array
 */
function get_config( string $name ): array {

	return Config::get( $name, 'cxl/jobs', CXL_BLOCKS_PLUGIN_FILE );
}

/**
 * The single instance of the app. Use this function for quickly working with
 * data.  Returns an instance of the `\CXL\Blocks\Core\Application` class. If the
 * `$abstract` parameter is passed in, it'll resolve and return the value from
 * the container.
 *
 * @since  5.0.0
 * @access public
 * @param  string  $abstract
 * @param  array   $params
 * @return mixed
 */
function app( $abstract = '', $params = [] ) {

	return App::resolve( $abstract ?: 'cxl-blocks', $params );
}
