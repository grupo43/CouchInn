<?php

class Paginator {
	private $db;
	private $limit;
	private $page;
	private $sql;
	private $total;

	public function __construct($db, $sql) {
		$this->db = $db;
		$this->sql = $sql;

		$result = $this->db->query($this->sql);
		$this->total = $result->num_rows;
	}

	public function getData($page) {
		$this->limit = 3;
		$this->page = $page;

		if ($this->limit == 'all') {
			$sql = $this->sql;
		} else {
			$sql = $this->sql." LIMIT ".(($this->page - 1) * $this->limit).", ".$this->limit;
		}

		$result = $this->db->query($sql);
		while ($row = $result->fetch_assoc()) {
			$results[] = $row;
		}

		$result = new stdClass();
		$result->page = $this->page;
		$result->limit = $this->limit;
		$result->total = $this->total;
		$result->data = $results;
		return $result;
	}

	public function getArrows() {
		$last = ceil($this->total / $this->limit);

		$html = '<nav><ul class="pager">';
		if ($this->page != 1) {
			$html .= '<li class="previous"><a href="" name="'.($this->page - 1).'"><span aria-hidden="true">&larr;</span> <strong>Más nuevos</strong></a></li>';
		}
		if ($this->page != $last) {
			$html .= '<li class="next"><a href="" name="'.($this->page + 1).'"><strong>Anteriores</strong> <span aria-hidden="true">&rarr;</span></a></li>';
		}
 		$html .= '</ul></nav>';

		return $html;
	}

}
