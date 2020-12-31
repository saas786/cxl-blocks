<?php
/**
 * Layout Config.
 *
 * Defines the default content mods. Child themes can overwrite this
 * with a `config/content-layouts.php` file for changing the defaults.
 *
 * @package CXL Blocks
 */

return [
	'default'  => [
		'label'            => esc_html_x( 'Default Layout', 'content layout', 'cxl-blocks' ),
		'type'             => [ 'site' ],
		'post_types'       => [ 'post', 'page' ],
		'_builtin'         => true,
		'_internal'        => true,
	],
	'1c-fluid'  => [
		'label'      => __( 'Content Wide', 'content layout', 'cxl-blocks' ), // Full Width Content
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
	],
	'1c'        => [
		'label'      => __( 'Content Boxed', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
	],
	'1c-narrow' => [
		'label'      => __( 'Content Narrow', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
		'is_default' => true,
	],
	'2c-l'      => [
		'label'      => __( 'Content, Primary Sidebar', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
	],
	'2c-r'      => [
		'label'      => __( 'Primary Sidebar, Content', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
	],
];
