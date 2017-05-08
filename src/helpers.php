<?php 

function _sf_view($file, $data = []){

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