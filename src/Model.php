<?php

namespace Kodeio\Database;

use PDO;
use Exception;
 
abstract class Model
{
	private $table;
	
	public function __construct(PDO $conn = null)
	{
		if(false === isset($this->name)){
			throw new Exception('Table name undefined.');
		}
		if(false === isset($this->index)){
			throw new Exception('Table index undefined.');
		}
		$this->table = new Table($this->name, $conn);
	}
	
	public function __get($name)
	{
		return $this->table->$name;
	}
	
	public function __call($method, $arguments)
	{
		call_user_func_array(
			array($this->table, $method), $arguments
		);
		return $this;
	}
	
	/* Query methods */
	
	public function first()
	{
		return $this->table->orderBy($this->index)->fetch();
	}
	
	public function last()
	{
		return $this->table->orderBy($this->index, 'DESC')->fetch();
	}
}
