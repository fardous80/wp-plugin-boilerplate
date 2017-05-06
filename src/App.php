<?php 

namespace App;

class App{

	public function __construct(){

		//echo 'App working';
	}

	public function setCustomFilterToChangeData() {

		add_filter('country', function($country){
			return 'BD';
		}, 2);

		add_filter('country', function($country){
			return 'PK';
		}, 1);


		// call filter

		$country = apply_filters('country', 'UK');

		echo 'changed UK to ' . $country;
		
	}


}