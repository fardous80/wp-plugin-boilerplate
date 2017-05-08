<?php 

namespace App\Wordpress;

/**
* Create custom Post Type
*/

class Taxonomy
{

	use TraitPostType;

	public function __construct($name, $label){

		$this->name = $name;

		$this->label = $label;
	}

	protected $args = [

		'labels' => null,

		'hierarchical' => true, // select parent dropbox

		'public' => true,

		'show_ui' => true,

		'show_in_admin_column' => true,

		'update_count_callback' => '_update_porst_term_count',

		'query_var' => true, // add reply_id to url

		'supports' => ['title']

	];
	

	public function register(){

		$this->setLabels();

		$this->args['labels'] = $this->labels;

		$that = $this;

		//die(var_dump($args));

		add_action('init', function() use ($that){

			register_taxonomy( $that->name, $that->belongsTo, $that->args);

		});
	}


}