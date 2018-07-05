<?php

spl_autoload_register(function ($class){
	$class = str_replace('Kodeio\Database\\', '', $class);
	$file = __DIR__ .'/../src/'. $class .'.php';
	if(file_exists($file)){
		require_once($file);
	}
});

Kodeio\Databae\Conn::global(
	'localhost', 'root', '', 'kupnfly_database', 3307
);
