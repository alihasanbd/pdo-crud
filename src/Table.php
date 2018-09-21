<?php

namespace Kodeio\Database;

use PDO;
use Exception;

class Table
{
	public $db, $order='', $limit=''; 
	public $name, $where='', $values=[]; 
	
	public function __construct($table, PDO $conn=null)
	{
		$this->db = new Query($conn);
		$this->name = $table;
	}
	
	protected function fetchSql($column='*')
	{
		return "SELECT {$column} FROM {$this->name} {$this->where} {$this->order} {$this->limit}";
	}
	
	/* Methods for IUD */
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
			return $this->db->exec($query, $values);
		}
		return null;
	}
	
	public function delete()
	{
		if(null != $this->where){
			$query = "DELETE FROM {$this->name} {$this->where}";
			return $this->db->exec($query, $this->values);
		}
		return null;
	}
	
	/* Methods for reading */
	public function fetch($column='*')
	{
		if($this->db->exec($this->fetchSql($column),$this->values)){
			if($data = $this->db->statement->fetch(PDO::FETCH_ASSOC)){
				return (object) $data;
			}
			return array();
		}
		return null;
	}
	
	public function fetchAll($column='*')
	{
		if($this->db->exec($this->fetchSql($column), $this->values)){
			if($data = $this->db->statement->fetchAll(PDO::FETCH_ASSOC)){
				return json_decode(json_encode($data));
			}
			return array();
		}
		return null;
	}	
	
	public function count(String $column='*')
	{
		$query = "SELECT COUNT({$column}) FROM {$this->name} {$this->where}";
		if($this->db->exec($query, $this->values)){
			return $this->db->statement->fetchColumn();
		}
		return null;
	}
	
	public function sum(String $column)
	{
		$query = "SELECT  SUM({$column}) FROM {$this->name} {$this->where}";
		if($this->db->exec($query, $this->values)){ 
			return $this->db->statement->fetchColumn();
		}
		return null;
	}
	
	public function orderBy($column, $order='ASC')
	{
		$this->order = "ORDER BY {$column} {$order}";
		return $this;
	}
	
	public function limit($arg1, $arg2=false)
	{
		$offset = (false === $arg2)? 0:$arg1; 
		$limit = (false === $arg2)? $arg1:$arg2; 
		$this->limit = "LIMIT {$limit} OFFSET {$offset}"; 
		return $this;
	}
	
	public function reset()
	{
		$this->where =''; $this->values =[]; 
		$this->order =''; $this->limit =''; 
	}
}
