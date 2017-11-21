<?php 

function _sf_view($file, $data = null){

	if(!$data) $data = [];

	$file = str_replace('.', '/', $file);

	extract($data);

	ob_start();
		require \App\Core\Config::get('root') . '/views/' . $file  . '.php';
		$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}

function _sf_meta_value($data, $key, $default=''){

	return isset($data[$key])?$data[$key][0]:$default;
}

function _sf_config($key){

	return \App\Core\Config::get($key);
}

function _sf_e($data){

	return esc_html__($data, _sf_config('app.text-domain'));

}

function _sf_get_fillable($fillable, $post=null){
	$post = $post?:$_POST;
	return array_intersect_key($post, array_flip($fillable));
}

function _sf_get_int($key, $default=false){
	return filter_input(INPUT_GET, $key, FILTER_VALIDATE_INT, [
		"options" => [
	    	"default" => $default
	    ]
	]);
}

function _sf_get_string($key, $default=false){
	return filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING, [
		"options" => [
	    	"default" => $default
	    ]
	]);
}

function _sf_get_array($key){
	return filter_input(INPUT_GET, $key, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
}

function _sf_post_int($key, $default=false){
	return filter_input(INPUT_POST, $key, FILTER_VALIDATE_INT, [
		"options" => [
	    	"default" => $default
	    ]
	]);
}

function _sf_post($key, $default=false){
	return filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING, [
		"options" => [
	    	"default" => $default
	    ]
	]);
}

function _sf_post_array($key){
	return filter_input(INPUT_POST, $key, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
}

function _sf_verify_nonce($key, $value){

	$value = _sf_post($value);
	
	if (! wp_verify_nonce( $value, $key ) ) {

	   print 'Sorry, your nonce did not verify.';
	   exit;

	}
}

function _sf_value($data, $key, $default=''){

	return isset($data[$key])?$data[$key][0]:$default;
}