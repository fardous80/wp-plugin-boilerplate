<?php

namespace App\Wordpress;

abstract class Wordpress extends Collection{
	
	protected $attributes = [];

	public function __get($key){

		return $this->getAttribute($key);
	}

	public function __set($key, $value)
	{
	
		$this->setAttribute($key, $value);
	
	}

	public function getAttribute($key)
    {
        if(array_key_exists($key, $this->attributes)){
    
           return $this->attributes[$key];

        }

        return '';
    
    }

    public function getAttributes(){
    
    	return $this->attributes;
    
    }

    public function __call($method, $arg){
    
    	$this->attributes[$method] = $arg[0];

    	return $this;
    
    }

}