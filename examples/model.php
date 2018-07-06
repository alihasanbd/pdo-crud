<?php

require_once(__DIR__ .'/autoload.php');


use Kodeio\Database\Model;

class TestDB extends Model
{
	protected $name = 'query_test', $index = 'id';
}


$test = new TestDB;
 
var_dump($test->upsert([
	'email' => 'alih1@gmail.com',
	'phone' => '1749-5588661'
], 'email'));  

echo "<pre>";
print_r($test->last()); 
echo "</pre>"; 

echo "<pre>";
print_r($test); 
echo "</pre>"; 
