<?php

namespace Kodeio;

use PDOException;
use Exception;
use PDO;

class Database
{
	public static $error=[], $db=false;

	public static function init(String $host, String $user, 
		String $pass, String $name, Int $port=3306)
	{
		try{
			$connection = new PDO(
				"mysql:host={$host};dbname={$name};port={$port}", $user, $pass
			);
			$connection->setAttribute(
				PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
			);
			return $connection;
		}
		catch(PDOException $e){
			self::$error[] = $e->getMessage();
			return null;
		}
	}

	public static function conn(String $h='', String $u='', 
		String $pw='', String $n='', Int $p=3306)
	{
		if(false === self::$db){
			if(empty($h) || empty($u) || empty($n)){
				throw new Exception(
					"Invalid database credentials."
				); 
			}
			self::$db = self::init($h, $u, $pw, $n, $p);
		}
        return self::$db;
	}
}
