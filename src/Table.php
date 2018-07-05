<?php

namespace Kodeio\Database;

use PDO;
use Exception;

class Table
{
	public $name, $query; 
	
	public function __construct($table, $conn=false)
	{
		$this->query = new Query($conn);
		$this->name = $table;
	}
	
}
