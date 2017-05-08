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

// Directories

define( '_sf_dir_', realpath(__DIR__ . '/../') );

define( '_sf_dir_views_', __DIR__ . '/../views/' );

define( '_sf_dir_config_', __DIR__ . '/../configs/' );

// autoloader

require __DIR__.'/../vendor/autoload.php';

// load all config files

foreach ( glob( _sf_dir_config_.'*.php' ) as $filename):
		$name = basename($filename, '.php');
        \App\Core\Config::bind($name, $value = require $filename);
endforeach;

\App\Core\Loader::bind(\App\Core\Config::get('aliases'));

spl_autoload_register( function($class){

	return \App\Core\Loader::load($class);

} );













