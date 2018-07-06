<?php

require_once(__DIR__ .'/autoload.php');


use Kodeio\Database\Model;

class TestDB extends Model
{
	protected $name = 'query_test';
}


$test = new TestDB;

echo "<pre>";
print_r($test);
