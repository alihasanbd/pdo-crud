<?php

namespace Kodeio\Database;
 
use PDO; 
use Kodeio\Database; 
use PDOException;

class Query
{
	public $conn, $statement, $error; 
	
	public function __construct(PDO $conn=null)
	{
		$this->conn = ($conn)?$conn:Database::conn(); 
	}
	
	public function exec($query, $values=[])
	{
		try{
			$this->error = null;
			$this->statement = $this->conn->prepare(
				$query, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
			); 		
			return $this->statement->execute($values);  
		}
		catch(PDOException $e){ 
			$this->error = $e->getMessage();
			return null;
		}
	}
}
