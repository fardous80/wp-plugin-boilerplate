<?php 

require( __DIR__ . '/autoloader.php' );

$app = new \App\Core\App(
	realpath( __DIR__ . '/../' )
);

return $app;