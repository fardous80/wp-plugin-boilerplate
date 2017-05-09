<?php 

namespace App\Components;

class Facade{

	public static function __callStatic($method, $args) { 

        //return 'anyhours-component';

        $class_name = '\\App\\Components\\' . ucfirst($method);

        $instance = new $class_name;

		if(count($args)==0)
			return $instance->render();

		else
			return call_user_func_array([$instance, 'render'], $args);

    }

}
