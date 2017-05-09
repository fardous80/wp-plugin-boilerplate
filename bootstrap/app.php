<?php 

/**
 * Plugin Name: WP Plugin Boilerplate
 * Plugin URI: http://www.anyhours.co.uk
 * Author: Nasim Mahmud
 */

// file must not be accessed directly

if( ! defined( 'ABSPATH' ) ) {

	exit;
}


require( __DIR__ . '/autoloader.php' );

$app = new \App\Core\App(
	realpath( __DIR__ . '/../' )
);

return $app;