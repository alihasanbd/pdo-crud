<?php

namespace Kodeio\Conn;

use PDOException;
use PDO;

class Conn
{	
	public static $error, $db = false;
	
	public static function init($host, $user, $pass, $name, $port)
	{
		try{
			return new PDO(
				"mysql:host={$host}; dbname={$name}; port={$port}", $user, $pass
			); 
		}
		catch(PDOException $e){
			self::$error = $e->getMessage();
		}
		return null;
	}
	
	public static function global($h='', $u='', $pw='', $n='', $p='')
	{
		if(self::$db === false){
			self::$db = self::init($h, $u, $pw, $n, $p);
			self::$db->setAttribute(
				PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
			);
		}
        return self::$db;
	}
}
