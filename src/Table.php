<?php

namespace Kodeio\Database;

use PDO;
use Exception;

class Table
{
	public $name, $db; 
	
	public function __construct($table, $conn=false)
	{
		$this->db = new Query($conn);
		$this->name = $table;
	}
	
	public function insert(Array $data)
	{
		$column = implode(', ', array_keys($data));
		$values = implode(', ', array_fill_keys(array_keys($data), '?'));
		$query = "INSERT INTO {$this->name} ({$column}) VALUES ({$values})";
		if($this->db->exec($query, array_values($data))){
			return $this->db->conn->lastInsertId();
		}
		return false;
	}
	
	
	
}
