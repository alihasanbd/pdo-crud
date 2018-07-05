<?php

namespace Kodeio\Database;

use PDOException;

class Query
{
	public $conn, $statement, $error; 
	
	public function __construct($conn=false)
	{
		$this->conn = ($conn)?$conn:Conn::global();
	}
	
	public function exec($query, $values=[])
	{
		try{
			$this->error = null;
			$this->statement = $this->conn->prepare($query); 		
			return $this->statement->execute($values);  
		}
		catch(PDOException $e){ 
			$this->error = $e->getMessage();
			return null;
		}
	}
}
