<?php 

namespace App\Components;

class BookInfo extends Component{


	public function render()
	{
		$this->create('book', 'book_attr', 'Book Attributes');
	}

	public function form($post)
	{
		$info = get_post_meta( $post->ID );
		
		echo $this->view(null, compact('info'));
	}

	public function save($post_id)
	{
		if(!_sf_post('book-info-form', null)) return;

		_sf_verify_nonce('book_info', 'book-info-form');

		update_post_meta($post_id, 'isbn', _sf_post('isbn', null));
	}
}