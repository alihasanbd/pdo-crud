<?php

namespace Kodeio\Database;
 
class Table_Helper
{
	protected function fetchSql($column='*')
	{
		return "SELECT {$column} FROM {$this->name} {$this->where}";
	}
}
