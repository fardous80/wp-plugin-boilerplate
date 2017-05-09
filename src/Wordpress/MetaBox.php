<?php 

namespace App\Wordpress;

/**
 * Add / Remove Metabox
 */

class MetaBox extends Wordpress{

	use TraitAction;

	function __construct($id=null, $label=null) {
		
		$this->id = $id;

		$this->label = $label;
	}

	public function attach($callback = null){

		$callback = $callback ? $callback : $this->callback;

		//die(var_dump($this));
	
		add_action( 'add_meta_boxes', function() use($callback){

			add_meta_box(

				$this->id,

				$this->label,

				$callback,

				$this->belongsTo,

				$this->context,

				$this->priority,

				$this->callback_args

			);

		});

		return $this;
	
	}

	public function save($callback){

		add_action('save_post_' . $this->belongsTo, $callback);

		return $this;
	
	}

	public function savePostMeta($post_id){
	
		if(! wp_verify_nonce($_POST[$nonce_value], $nonce_key) ){

			die('nonce invalid');
		}

		die($post_id);
	
	}


	public function remove(){

		$that = $this;
	
		add_action('wp_dashboard_setup', function() use ($that){

			// remove_meta_box( $item_id, $page_it_belongs, $where_it_apperas );

			remove_meta_box($that->id, $that->belongsTo, $that->context);
		});
	
	}

}