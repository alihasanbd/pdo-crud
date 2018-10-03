<?php

require_once(__DIR__ .'/autoload.php');

$test = new Kodeio\Database\Table('query_test');

echo '<pre>';
print_r($test->fetch());
echo '</pre>';

echo '<pre>';
print_r($test);
echo '</pre>';

echo '<pre>';
print_r($test->statement);
echo '</pre>';
