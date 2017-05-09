<?php 

namespace App\Components;

use App\Wordpress\MetaBox;

class ImageGallery extends Component{

	/**
	 * A component for attaching images to post
	 * image id will be saved in post_meta: post_id, key:_sf_image_gallery_ids, value: image  
	 * ids separate by commas
	 *
	 * @args( id: string*, label*: string, post_type*: string, callback: closure )
	 *
	 */

	protected $callback = null;

	public function render($id, $label, $post_type, $callback=null){

		$this->callback = $callback;

		(new MetaBox($id, $label))
			->belongsTo($post_type)
			->attach(function($post){

				$data = $this->getAttachments($post->ID);

				echo $this->view('image-gallery', compact('data'));
			})
			->save(function($post_id){

				_sf_verify_nonce('_sf_image_gallery_', 'image-gallery-selector');

				$ids = _sf_post('_sf_image_gallery_ids', '');

				update_post_meta($post_id, '_sf_image_gallery_ids', $ids);
			});
	
	
	}

	public function getAttachments($post_id){
	
		$meta = _sf_meta_value( get_post_meta( $post_id ), '_sf_image_gallery_ids' );

		$ids = explode(',', $meta);

		$data['ids'] = trim($meta);

		$images = [];

		if(count($ids) > 0){

			$images = array_map(function($id){

				return ['id' => $id, 'url' => wp_get_attachment_image_src($id, 'thumbnail')[0]];

			}, $ids);

		}

		$data['images'] = $images;

		return $data;
	
	}

}
