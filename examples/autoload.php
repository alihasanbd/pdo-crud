<?php

spl_autoload_register(function ($class){
	$class = str_replace('Kodeio\Database\\', '', $class);
	$file = __DIR__ .'/../src/'. $class .'.php';
	if(file_exists($file)){
		require_once($file);
	}
});

Kodeio\Database\Conn::global(
	'localhost', 'root', '', 'phpcrud_test', 3307
);
