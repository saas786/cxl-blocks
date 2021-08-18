<?php
/**
 * Plugin bootstrap file.
 *
 * This file is used to create a new application instance and bind items to the
 * container. This is the heart of the application.
 *
 * @package   CXL Blocks
 */

// ------------------------------------------------------------------------------
// Create a new application.
// ------------------------------------------------------------------------------
//
// Creates the one true instance of the Hybrid Core application. You may access
// this instance via the `\Hybrid\app()` function or `\Hybrid\App` static class
// after the application has booted.
$cxl_blocks = \Hybrid\booted() ? \Hybrid\app() : new \Hybrid\Core\Application();

// ------------------------------------------------------------------------------
// Register service providers with the application.
// ------------------------------------------------------------------------------
//
// Before booting the application, add any service providers that are necessary
// for running the plugin. Service providers are essentially the backbone of the
// bootstrapping process.
$cxl_blocks->provider( \CXL\Blocks\Provider::class );
$cxl_blocks->provider( \CXL\Blocks\Layout\Provider::class );

// ------------------------------------------------------------------------------
// Perform bootstrap actions.
// ------------------------------------------------------------------------------
//
// Creates an action hook for parent/child themes (or even plugins) to hook into the
// bootstrapping process and add their own bindings before the app is booted by
// passing the application instance to the action callback.
do_action( 'cxl/blocks/bootstrap', $cxl_blocks );

// ------------------------------------------------------------------------------
// Bootstrap the application.
// ------------------------------------------------------------------------------
//
// Calls the application `boot()` method, which launches the application. Pat
// yourself on the back for a job well done.
$cxl_blocks->boot();

// Store app instance to globals.
$GLOBALS['cxl_blocks_container'] = $cxl_blocks;
