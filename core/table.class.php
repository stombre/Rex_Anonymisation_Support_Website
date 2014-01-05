<?php

class Table
{
	const COLUMN_OTHER = 0;
	const COLUMN_CHAR = 1;
	const COLUMN_DATETIME = 2;
	const COLUMN_TEXT = 3;
	const COLUMN_BLOB = 4;
	const COLUMN_INT = 5;
	private $table_name;
	private $column_name = array();
	private $column_type = array();
	private $column_key = array();
	
	function __construct($pdo, $table)
	{
		$q = $pdo -> query('SHOW COLUMNS FROM '.$table);
		$this->table_name = $table;
		while($data = $q -> fetch())
		{
			array_push($this->column_name, $data['Field']);
			array_push($this->column_type, $data['Type']);
			array_push($this->column_key, $data['Key']);
		}
		$q->closeCursor();
	}
	
	public function getName()
	{
		return $this->table_name;
	}

	public function getNbColumn()
	{
		return count($this->column_name);
	}
	
	public function getColumName($columnID)
	{
		return $this->column_name[$columnID];
	}
	
	public function getColumKey($columnID)
	{
		return $this->column_key[$columnID];
	}
	
	public function getColumType($columnID)
	{
		return $this->column_type[$columnID];
	}
}


?>