<?php

namespace Kodeio\Database;

use PDO;
use Exception;
 
abstract class Model
{
	protected $table;
	
	public function __construct(PDO $conn = null)
	{
		if(false === isset($this->name)){
			throw new Exception('Table name undefined.');
		} 
		$this->table = new Table($this->name, $conn);
	}
}
