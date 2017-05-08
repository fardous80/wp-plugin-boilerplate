<?php

namespace App\Core;

/**
* App class
*
* DI container class
*/

class App
{

	/**
	 * Data holder
	 */
	protected $root;

	public function __construct($root)
	{
	
		$this->root = $root;

		$this->loadConfigs();

		$this->loadAliases();
	
	}

	protected function loadConfigs(){

		// save root directory to config storage

		Config::bind('root', $this->root);

		// load all config files

		foreach ( glob( $this->root . '/configs/*.php' ) as $filename):

			$name = basename($filename, '.php');

	        Config::bind($name, $value = require $filename);

		endforeach;
	}

	protected function loadAliases(){

		Loader::bind(\App\Core\Config::get('aliases'));

		spl_autoload_register( function($class){

			return Loader::load($class);

		} );
	}

	public function run(){
	
		if(is_admin()){

			return require $this->root . '/app/Back.php';
			
		}else{

			return require $this->root . '/app/Front.php';

		}

		
	
	}
}