<?php

require_once(__DIR__ .'/autoload.php');

$test = new Kodeio\Database\Table('query_test');

echo '<pre>';
print_r($test->insert([
	"name" => "Ali Hasan4",
	"email" => "alih4@gmail.com",
	"phone" => "17495588664"
]));


