<?php 

namespace App\Actions;

/**
* Create custom Post Type
*/

class PostType
{

	use TraitPostType;

	public function __construct($id, $label=null){

		$this->id = $id;

		$this->label = $label?:ucfirst($id);
	}

	protected $args = [

		'labels' => null,

		'public' => true,

		'show_ui' => true,

		'show_in_admin_bar' => true,

		'hierarchical' => false,

		'capability_type' => 'page',

		'query_var' => true,

		'has_archive' => true,

		'supports' => []

	];
	

	public function register(){

		$this->setLabels();

		$args = $this->args;

		$args['labels'] = $this->labels;

		$id = $this->id;

		//die(var_dump($args));

		add_action('init', function() use ($id, $args){

			register_post_type( $id, $args);

		});
	}


}