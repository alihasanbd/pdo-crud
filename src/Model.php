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
		$result = call_user_func_array(
			array($this->table, $method), $arguments
		);
		if($result instanceof Table){
			return $this;
		}
		return $result;
	}
	
	/* Query methods */  
	public function last()
	{
		$data = $this->table->orderBy($this->index, 'DESC')->fetch();
		$this->table->order = '';
		return $data;
	}
	
	public function upsert(Array $data, $compare)
	{
		$index = $this->index; 
		if(false === isset($data[$compare])){
			throw new Exception('Invalid compare column/value.');
		}
		$this->where("{$compare}=?", [$data[$compare]]);
		if($row = $this->table->fetch()){ 
			$this->where("{$this->index}=?", [$row->$index]);
			if(true == $this->table->update($data)){
				$this->table->where = '';
				return $row->$index;
			}
			return false;
		}
		return $this->table->insert($data);
	}
}
