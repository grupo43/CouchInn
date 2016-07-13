<?php

require_once 'resources/library/functions.php';
class DataAccessObject
{
	private $db;
	public $table;

	public function __construct($table)
	{
		$this->db = connect();
		$this->table = $table;
	}

	public static function query($sql) {
		$db = connect();
		return $db->query($sql);
	}
	
	public function create($values) {
		if (sizeof($values)):
			$columnsSQL = "(";
			$valuesSQL = "(";
			foreach ($values as $column => $value):
				$columnsSQL		.= "`$column`,";
				$valuesSQL		.= "'$value',";
			endforeach;
			$columnsSQL		= substr($columnsSQL, 0, -1);
			$valuesSQL		= substr($valuesSQL, 0, -1);
			$columnsSQL		.= ")";
			$valuesSQL		.= ")";
			$sql = "INSERT INTO $this->table $columnsSQL VALUES $valuesSQL";
			if ($this->db->query($sql)):
				return $this->db->insert_id;
			endif;
		endif;
		return false;
	}

	public function findBy($column, $value) {
		$sql = "SELECT * FROM $this->table WHERE $column = '{$value}'";
		$result = $this->db->query($sql);
		if ($result->num_rows):
			return $result->fetch_assoc();
		endif;
		return false;
	}

	public function findById($id) {
		return $this->findBy('id', $id);
	}

	public function removeBy($column, $value) {
		$sql = "DELETE FROM $this->table WHERE $column = '{$value}'";
		return $this->db->query($sql);
	}

	public function removeById($id) {
		return $this->removeBy('id', $id);
	}
}
