<?php 

namespace App\Wordpress;

trait TraitPostType{

	use TraitAction;

	protected $plural = null;

	protected $label = null;

	protected $labels = [

		'name' => '_plural_',

		'singular_name' => '_label_',

		'menu_name' => '_plural_',

		'name_admin_bar' => '_plural_',

		'add_new' => 'New _label_',

		'add_new_item' => 'Add New _label_',

		'view_item' => 'View _label_',

		'all_items' => 'View All _plural_',

		'search_items' => 'Find _plural_'

	];

	public function labels($labels) {

		if( empty($labels) ) return $this;

		foreach($labels as $k=>$v){

			$this->labels[$k] = $v;
		}

		return $this;

	}

	public function args( $args ){

		if( empty($args) ) return $this;

		foreach($args as $k=>$v){

			$this->args[$k] = $v;
		}

		return $this;
	}

	public function setLabels(){

		$plural = $this->plural?:$this->label . 's';

		foreach($this->labels as $k=>$v){

			$this->labels[$k] = str_replace(['_label_', '_plural_'], [$this->label, $plural], $v);
		}

		return $this;

	}

}