<?php 

namespace App\Components;

abstract class Component{

	public function view($tpl=null,$data=null){

	
		if(! $tpl){

			$class = (new \ReflectionClass($this))->getShortName();;


			$parts = preg_split('/(?=[A-Z])/', $class, -1, PREG_SPLIT_NO_EMPTY);


			$tpl = strtolower(implode('-', $parts));
		}

		return _sf_view('components.' . $tpl . '.' . $tpl, $data);
	
	}
}
