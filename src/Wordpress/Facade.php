<?php 

namespace App\Wordpress;

class Facade{

	public static function __callStatic($method, $args=null) {

		$class = '\\App\\Wordpress\\' . $method;

		$reflect  = new \ReflectionClass($class);

		return $reflect->newInstanceArgs($args);
		
	}

}