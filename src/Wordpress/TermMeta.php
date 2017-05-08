<?php 

namespace App\Wordpress;

/**
 * Add / Remove Metabox
 */

class TermMeta{

	protected $id = null;

	function __construct($id) {
		
		$this->id = $id;
	}

	public function create($callback){
	
		add_action( $this->id . '_add_form_fields', $callback );

		return $this;
	
	}

	public function save($callback){
	
		add_action( 'create_' . $this->id, $callback);

		return $this;
		
	
	}

	public function edit($callback){
	
		add_action( $this->id . '_edit_form_fields', $callback );

		return $this;
	
	}

	public function update($callback){
	
		add_action( 'edit_' . $this->id, $callback);

		return $this;
		
	
	}

}