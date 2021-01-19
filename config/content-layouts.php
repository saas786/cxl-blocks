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
	'1c'        => [
		'label'      => esc_html_x( '1-column, Content Wide', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
	],
	'1c-w'        => [
		'label'      => esc_html_x( '1-column, Content Wide (deprecated)', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
	],
	'1c-fluid'  => [
		'label'      => esc_html_x( '1-column, Content Full Width', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
	],
	'1c-c' => [
		'label'      => esc_html_x( '1-column, Content Narrow (deprecated)', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
		'is_default' => true,
	],
	'1c-narrow' => [
		'label'      => esc_html_x( '1-column, Content Narrow', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
		'is_default' => true,
	],
	'2c'      => [
		'label'      => esc_html_x( '2-column, commons', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
	],
	'2c-l'      => [
		'label'      => esc_html_x( '2-column, content left', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
	],
	'2c-r'      => [
		'label'      => esc_html_x( '2-column, content right', 'content layout', 'cxl-blocks' ),
		'type'       => [ 'site' ],
		'post_types' => [ 'post', 'page' ],
	],
];
