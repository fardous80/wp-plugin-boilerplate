<?php 

namespace App\Wordpress;

/**
* Create custom Post Type
*/

class Post extends Wordpress
{

	use TraitPostType;

	protected $relations = [];

	public function __construct($name = null, $label=null){

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

	public function get(){
	
		$attributes = $this->attributes;

		$attributes['post_type'] = $this->name;

		$posts = get_posts($attributes);

		foreach($posts as $post):

			$post->permalink = get_permalink($post->ID);

		endforeach;

		$this->mapRelations($posts);

		return new Collection($posts);
	
	}

	public function single($post_id = null){
	
		$post = get_post($post_id);

		return (new Collection())->mapObject($post);
	
	}

	public function with($relation){
	
		array_push($this->relations, $relation);

		return $this;
	
	}

	public function attachments($posts){
	
		foreach($posts as $post){

			$post->thumbnail = get_the_post_thumbnail_url($post->ID);

			$post->image_medium = get_the_post_thumbnail_url($post->ID, 'medium');
		}

	
	}

	public function mapRelations($posts){
	
		foreach($this->relations as $relation)

			call_user_func_array([$this, $relation], [$posts]);
		
	
	}


}