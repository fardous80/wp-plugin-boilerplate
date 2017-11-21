<?php 

namespace App\Components;

use App\Wordpress\MetaBox;

abstract class Component{

	public function view($tpl=null,$data=null){

	
		if(! $tpl){

			$class = (new \ReflectionClass($this))->getShortName();;


			$parts = preg_split('/(?=[A-Z])/', $class, -1, PREG_SPLIT_NO_EMPTY);


			$tpl = strtolower(implode('-', $parts));
		}

		return _sf_view('components.' . $tpl, $data);
	
	}

	public function create($post_type, $name, $title)
	{
		(new MetaBox($name, $title))
			->belongsTo($post_type)
			->priority('high')
			->attach(function($post){
				$this->form($post);
			})
			->save(function($post_id){
				$this->save($post_id);
			});

	}
}
