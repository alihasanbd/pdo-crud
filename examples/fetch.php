<?php

require_once(__DIR__ .'/autoload.php');

$test = new Kodeio\Database\Table('query_test');

echo '<pre>';
print_r($test->fetch());


