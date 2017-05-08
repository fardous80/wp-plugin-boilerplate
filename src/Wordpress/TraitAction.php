<?php 

namespace App\Wordpress;

trait TraitAction{

	protected $id = null;

	protected $name = null;

	protected $label = null;

	protected $slug = null;

	protected $context = 'normal'; // [normal, side, *advanced]

	protected $priority = 'low'; // [low, high]

	protected $callback = null;

	protected $callback_args = [];

	protected $plural = null;

	protected $taxonomy = null;

	protected $belongsTo = null;

	public function id($id){
	
		$this->id = $id;

		return $this;
	
	}


	public function label($label){
	
		$this->label = $label;

		return $this;
	
	}

	public function name($name){
	
		$this->name = $name;

		return $this;
	
	}

	public function slug($slug=''){
	
		$this->slug = $slug;

		return $this;
	
	}

	public function context($context){
	
		$this->context = $context;

		return $this;
	
	}

	public function priority($priority){
	
		$this->priority = $priority;

		return $this;
	
	}

	public function callback($callback){
	
		$this->callback = $callback;

		return $this;
	
	}

	public function callWith($args){
	
		$this->callback_args = $args;

		return $this;
	
	}

	public function plural($plural){
	
		$this->plural = $plural;
	
	}

	/*
	|----------------------
	|Use
	|----------------------
	| taxonomy belongs to a post
	| meta belongs to a taxonomy
	*/

	public function belongsTo($belongsTo){

		$this->belongsTo = $belongsTo;

		return $this;
	}

}