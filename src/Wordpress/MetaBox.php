<?php 

namespace App\Wordpress;

/**
 * Add / Remove Metabox
 */

class MetaBox{

	use TraitAction;

	function __construct($id=null, $label=null) {
		
		$this->id = $id;

		$this->label = $label;
	}

	public function attach(){

		//die(var_dump($this));
	
		add_action( 'add_meta_boxes', function() {

			add_meta_box(

				$this->id,

				$this->label,

				$this->callback,

				$this->slug,

				$this->context,

				$this->priority,

				$this->callback_args

			);

		});
	
	}


	public function remove(){

		$that = $this;
	
		add_action('wp_dashboard_setup', function() use ($that){

			// remove_meta_box( $item_id, $page_it_belongs, $where_it_apperas );

			remove_meta_box($that->id, $that->belongsTo, $that->context);
		});
	
	}

}