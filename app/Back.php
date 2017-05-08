<?php 

// remove wp news from admin dashboard

w::MetaBox()
	->id('dashboard_primary')
	->slug('dashboard')
	->context('side')
	->remove();


// set custom post type

w::Post('job', 'Job')
	->labels(['all_items' => 'Job Listings'])
	->args(['supports' => ['title', 'thumbnail']])
	->register();

// set taxonomy for custom post type

w::Taxonomy('location', 'Location')
	->belongsTo('job')
	->register();

// add meta box

w::MetaBox('job_listing_box', 'Job Listing')
	->belongsTo('job') // in which page or post section it should appear
	->context('normal') // page section it should appear
	->priority('low')

	->callback(

		function($post, $data){

			$data = get_post_meta( $post->ID );

			echo _sf_view('jobs.form', compact('data'));

		}

	)
	->callWith(['name' => 'Nasim Hayath'])
	->attach();

// save post

add_action('save_post_job', function($post_id){

	if ( wp_is_post_revision( $post_id ) )
		return;

	if(!isset($_POST['job_id'])) return;

	update_post_meta($post_id, 'job_id', sanitize_text_field( $_POST['job_id'] ) );
});

function social_networks() {

	return [

		'facebook' => _sf_e('Facebook'),

		'twitter' => _sf_e('Twitter')

	];
}


w::TermMeta('location')

	->create(function(){

		$networks = social_networks();

		echo _sf_view('jobs.locations.meta-form', compact('networks'));

	})

	->save(function($term_id) {

		if(! wp_verify_nonce($_POST['location-meta-form'], 'wpb_nonce') ){

			die('nonce invalid');
		}

		foreach(social_networks() as $key => $network){

			if(isset($_POST[$key]))	{

				update_term_meta($term_id, 'location_' . $key, esc_url_raw($_POST[$key]));

			}
		}

	})

	->edit(function($term){

		$data = get_term_meta($term->term_id);

		$networks = social_networks();

		echo _sf_view('jobs.locations.edit-form', compact('networks', 'data'));

	})

	->update(function($term_id){

		if(! wp_verify_nonce($_POST['location-meta-form'], 'wpb_nonce') ){

			die('nonce invalid');
		}


		foreach(social_networks() as $key => $network){

			if(isset($_POST[$key]))	{

				update_term_meta($term_id, 'location_' . $key, esc_url_raw($_POST[$key]));

			}
		}
	});
