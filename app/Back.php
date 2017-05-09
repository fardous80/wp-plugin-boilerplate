<?php 

// remove wp news from admin dashboard

w::MetaBox()
	->id('dashboard_primary')
	->slug('dashboard')
	->context('side')
	->remove();

// Add custom post Books

w::Post('book', 'Book')
	->labels([
		'all_items' => 'Books',

		'add_new' => 'New Book',

		'add_new_item' => 'Add New Book',
	])
	->args([

		'supports' => ['title', 'excerpt', 'comments', 'thumbnail']
	])
	->register();

// ImageGallery Component can attach multiple images to a post

c::ImageGallery('book_image_gallery', 'Image Gallery', 'book');


// Book Categories

w::Taxonomy('sf_book_category', 'Category')
	->plural('Categories')
	->belongsTo('book')
	->register();