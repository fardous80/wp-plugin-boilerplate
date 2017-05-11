<?php

namespace App\Wordpress;

class Collection extends \ArrayObject{
	
	protected $attributes = [];

	protected $instances = [];

	function __construct($objects=null)
	{

		if($objects){
			
			$this->mapObjects($objects);

			parent::__construct($this->instances);
		}

	}

	public function mapObjects($objects){

		
		foreach($objects as $obj)
			array_push($this->instances, $this->mapObject($obj));
		
	
	}

	public function mapObject($obj) {

		$instance = new self;
	
		foreach($obj as $key=>$val)
			$instance->$key = $val;

		return $instance;
	
	}

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


    		if(is_string($this->attributes[$key]))

    			return esc_html($this->attributes[$key]);

    		return $this->attributes[$key];

        }

        return '';
    
    }

    public function getAttributes(){
    
    	return $this->attributes;
    
    }

    public function setAttributes(array $attributes)
    {
    
    	$this->attributes = (array) $attributes;

    }

        public function setAttribute($key, $val)
    {
    
        $this->attributes[$key] = $val;
    
    }

    public function uppercase($key){
    
    	return strtoupper($this->$key);
    
    }

    public function raw($key){
    
    	return $this->attributes[$key];;
    
    }


}