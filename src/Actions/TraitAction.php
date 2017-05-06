<?php 

namespace App\Actions;

trait TraitAction{

	protected $id = null;

	protected $label = null;

	protected $slug = null;

	protected $context = 'normal'; // [normal, side, *advanced]

	protected $priority = 'low'; // [low, high]

	protected $callback = null;

	protected $callback_args = [];

	protected $plural = null;

	protected $taxonomy = null;


	public function label($label){
	
		$this->label = $label;

		return $this;
	
	}

	public function id($id){
	
		$this->id = $id;

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

}