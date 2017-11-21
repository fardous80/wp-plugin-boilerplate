<?php
/**
 * Plugin Name: Books
 * Plugin URI: http://www.anyhours.co.uk
 * Author: Nasim Mahmud
 */

$app = require( __DIR__ . '/bootstrap/app.php' );

//$app->run();

// add custom post books

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

// add book attributes fields

c::BookInfo();