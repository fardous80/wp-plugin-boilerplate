<?php 

namespace App\Actions;

class Action{

	public static function __callStatic($method, $args=null) {

		$class = '\\App\\Actions\\' . $method;

		$reflect  = new \ReflectionClass($class);

		return $reflect->newInstanceArgs($args);
		
	}

}