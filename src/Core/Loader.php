<?php 

namespace App\Core;


class Loader{

	protected static $aliases = [];

	public static function bind($aliases){

		static::$aliases = $aliases;

	}

	public static function load($alias){
	
		if(array_key_exists($alias, self::$aliases)){

			return class_alias(static::$aliases[$alias], $alias);
		}
	
	}
}