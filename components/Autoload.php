<?php

spl_autoload_register(function ($class_name){
	$array_paths= array(
		'/config/',
		'/components/lib/',
		'/components/',
		'/models/'
	);

	foreach($array_paths as $path){
		$path= ROOT.$path.$class_name.'.php';
		if(is_file($path)){
			include_once $path;
		}
	}
});
