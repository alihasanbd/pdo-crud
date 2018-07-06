<?php

require_once(__DIR__ .'/autoload.php');


use Kodeio\Database\Model;

class TestDB extends Model
{
	protected $name = 'query_test', $index = 'id';
}


$test = new TestDB;
 
var_dump($test->insert([
	'name' => 'Ali H1012',
	'email' => 'alih100@gmail.com',
	'phone' => '17490558866'
]));  

