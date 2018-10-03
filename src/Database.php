<?php

namespace Kodeio;

use PDOException;
use PDO;

class Database
{	
	public static $error, $db = false;
	
	public static function init($host, $user, $pass, $name, $port=3306)
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
			self::$error = $e->getMessage();
			return null;
		}
	}
	
	public static function conn($h='', $u='', $pw='', $n='', $p=3306)
	{
		if(self::$db === false){
			self::$db = self::init($h, $u, $pw, $n, $p); 
		}
        return self::$db;
	}
}
