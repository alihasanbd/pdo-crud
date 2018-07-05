<?php

namespace Kodeio\Database;
 
abstract class Table_Helper
{
	protected function fetchSql($column='*')
	{
		return "SELECT {$column} FROM {$this->name} {$this->where}";
	}
}
