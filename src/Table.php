<?php

namespace Kodeio\Database;

use PDO;
use Exception;

class Table extends Query
{
	public $name;
	private $order='', $limit='', $where='', $values=[];
	
	public function __construct(String $table, PDO $conn=null)
	{
		parent::__construct($conn); 
		$this->name = $table;
	}
	
	public function query(String $sql, Array $values=[])
	{
		return $this->exec($sql, $values);
	}
	
	protected function fetchSql(String $column='*')
	{
		return "SELECT {$column} FROM {$this->name} {$this->where} {$this->order} {$this->limit}";
	}
	
	/* Methods for IUD */
	public function insert(Array $data)
	{
		$column = implode(', ', array_keys($data));
		$values = implode(', ', array_fill_keys(array_keys($data), '?'));
		$query = "INSERT INTO {$this->name} ({$column}) VALUES ({$values})";
		if($this->exec($query, array_values($data))){
			return $this->conn->lastInsertId();
		}
		return false;
	}
	
	public function where(String $where, Array $values=[])
	{
		$this->values = $values; 
		$this->where = 'WHERE '. $where; 
		return $this;
	}
	
	public function update(Array $data)
	{
		if(null != $this->where){
			$columns = implode('=?, ', array_keys($data)) .'=?';
			$values = array_merge(array_values($data), $this->values);
			$query = "UPDATE {$this->name} SET {$columns} {$this->where}";
			return $this->exec($query, $values);
		}
		return null;
	}
	
	public function delete()
	{
		if(null != $this->where){
			$query = "DELETE FROM {$this->name} {$this->where}";
			return $this->exec($query, $this->values);
		}
		return null;
	}
	
	/* Methods for reading */
	public function fetch(String $column='*')
	{
		if($this->exec($this->fetchSql($column),$this->values)){
			if($data = $this->statement->fetch(PDO::FETCH_ASSOC)){
				return (object) $data;
			}
			return array();
		}
		return null;
	}
	
	public function fetchAll(String $column='*')
	{
		if($this->exec($this->fetchSql($column), $this->values)){
			if($data = $this->statement->fetchAll(PDO::FETCH_ASSOC)){
				return json_decode(json_encode($data));
			}
			return array();
		}
		return null;
	}	
	
	public function count(String $column='*')
	{
		$query = "SELECT COUNT({$column}) FROM {$this->name} {$this->where}";
		if($this->exec($query, $this->values)){
			return $this->statement->fetchColumn();
		}
		return null;
	}
	
	public function sum(String $column)
	{
		$query = "SELECT  SUM({$column}) FROM {$this->name} {$this->where}";
		if($this->exec($query, $this->values)){ 
			return $this->statement->fetchColumn();
		}
		return null;
	}
	
	public function orderBy(String $column, String $order='ASC')
	{
		$this->order = "ORDER BY {$column} {$order}";
		return $this;
	}
	
	public function limit(Int $arg1, Int $arg2=null)
	{
		$offset = (null === $arg2)? 0:$arg1; 
		$limit = (null === $arg2)? $arg1:$arg2; 
		$this->limit = "LIMIT {$limit} OFFSET {$offset}"; 
		return $this;
	}
	
	public function reset()
	{
		$this->where =''; $this->values =[]; 
		$this->order =''; $this->limit =''; 
	}
}
