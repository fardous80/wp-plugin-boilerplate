<?php
/**
 * Plugin Name: WP Plugin Boilerplate
 * Plugin URI: http://www.anyhours.co.uk
 * Author: Nasim Mahmud
 */

// file must not be accessed directly

if( ! defined( 'ABSPATH' ) ) {

	exit;
}

require __DIR__.'/vendor/autoload.php';

// remove wp news from admin dashboard

\App\Actions\Action::MetaBox()
	->id('dashboard_primary')
	->slug('dashboard')
	->context('side')
	->remove();


// set custom post type

\App\Actions\Action::PostType('job', 'Jobs')
	->labels(['all_items' => 'Job Listings'])
	->args(['supports' => ['title', 'thumbnail']])
	->register();

// set taxonomy for custom post type

\App\Actions\Action::Taxonomy('job', 'location', 'Location')->register();

// add meta box

\App\Actions\Action::MetaBox('job_listing_box', 'Job Listing')

	->callback(

		function($post, $data){

			echo 'content for: ' . $data['args']['name'];

		}

	)
	->slug('job') // in which page or post section it should appear
	->context('normal')
	->priority('low')
	->callWith(['name' => 'Nasim Hayath'])
	->attach();











