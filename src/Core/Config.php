<?php

namespace App\Core;

/**
* App class
*
* DI container class
*/

class Config
{

	/**
	 * Data holder
	 */
	protected static $registry;

	public static function bind($key, $value)
	{
	
		static::$registry[$key] = $value;
	
	}

	public static function get($key)
	{

		if(! array_key_exists($key, static::$registry))

			return null;
			

		return static::$registry[$key];

	}

	public static function __callStatic($mthod, $args){
		if(empty($args) && array_key_exists($method, static::$registry))
    		return static::$registry[$method];

        else if(count($args)>0)
           return static::$registry[$method] = $args[0];
       
        else
            return null;
	}
}