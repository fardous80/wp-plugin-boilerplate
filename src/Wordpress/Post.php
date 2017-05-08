<?php 

namespace App\Wordpress;

/**
* Create custom Post Type
*/

class Post
{

	use TraitPostType;

	public function __construct($name, $label=null){

		$this->name = $name;

		$this->label = $label?:ucfirst($name);
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

		$name = $this->name;

		//die(var_dump($args));

		add_action('init', function() use ($name, $args){

			register_post_type( $name, $args);

		});
	}


}