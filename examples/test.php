<?php

require_once(__DIR__ .'/autoload.php');

$test = new Kodeio\Database\Table('query_test');

echo '<pre>';
print_r($test->insert([
	"name" => "Ali Hasan",
	"email" => "alih@gmail.com",
	"phone" => "1749558866"
]));


