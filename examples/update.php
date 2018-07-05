<?php

require_once(__DIR__ .'/autoload.php');

$test = new Kodeio\Database\Table('query_test');

echo '<pre>';
print_r($test->where('id=?', [2])->update([
	"name" => "Ali Hasan2",
	"email" => "alih2@gmail.com",
	"phone" => "17495588662"
]));


