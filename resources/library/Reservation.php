<?php
require_once 'resources/library/DataAccessObject.php';

class Reservation
{
	private $reservationDao;
	private $acceptedReservationDao;
	private $deniedReservationDao;
	public $id;
	public $couch_id;
	public $guest;
	public $num_guests;
	public $from;
	public $till;

	public function __construct($data = array())
	{
		$this->reservationDao			= new DataAccessObject('reservation');
		$this->acceptedReservationDao	= new DataAccessObject('accepted_reservation');
		$this->deniedReservationDao		= new DataAccessObject('denied_reservation');
		if (!empty($data)) {
			$this->fill($data);
			$this->id = $this->reservationDao->create($data);
		}
	}

	public static function withId($id) {
		$instance = new self();
		$instance->loadById($id);
		return $instance;
	}

	protected function loadByID($id) {
		$row = $this->reservationDao->findById($id);
		$this->fill($row);
	}

	protected function fill(array $row) {
		if (isset($row['id'])) {
			$this->id		= $row['id'];
		}
		$this->couch_id		= $row['couch_id'];
		$this->guest		= $row['guest'];
		$this->num_guests	= $row['num_guests'];
		$this->from			= new DateTime($row['from']);
		$this->till			= new DateTime($row['till']);
	}

	public function wasAccepted() {
		return $this->acceptedReservationDao->findBy('reservation_id', $this->id);
	}

	public function wasDenied() {
		return $this->deniedReservationDao->findBy('reservation_id', $this->id);
	}

	public function hasStarted() {
		$today = new DateTime();
		return ($today >= $this->from);
	}

	public function hasEnded() {
		$today = new DateTime();
		return ($today >= $this->till->modify('+1 day'));
	}

	public function stillPending() {
		$today = new DateTime();
		$today = new DateTime($today->format('Y-m-d'));
		return ($today <= $this->from);
	}

	public function isOnGoing() {
		return ($this->hasStarted() && !$this->hasEnded());
	}

	public function accept() {
		$values = array('reservation_id' => $this->id);
		if ($this->acceptedReservationDao->create($values)) {
			foreach ($this->reservationsInSameRange() as $reservation) {
				$values = array('reservation_id' => $reservation['id']);
				$this->deniedReservationDao->create($values);
			}
			return true;
		}
		
		return false;
	}

	public function deny() {
		$values = array('reservation_id' => $this->id);
		return $this->deniedReservationDao->create($values);
	}

	public function reservationsInSameRange() {
		$from = $this->from->format('Y-m-d');
		$till = $this->till->format('Y-m-d');
		$sql = "
			SELECT r.id
			FROM reservation AS r
			WHERE
				r.couch_id = {$this->couch_id}
				AND r.id != {$this->id}
				AND (
					(r.from BETWEEN '{$from}' AND '{$till}') OR
					(r.till BETWEEN '{$from}' AND '{$till}') OR
					(r.from < '{$from}' AND r.till > '{$till}')
				)
		";
		return DataAccessObject::query($sql)->fetch_all(MYSQLI_ASSOC);
	}

	public function reservationsAcceptedInSameRange() {
		$from = $this->from->format('Y-m-d');
		$till = $this->till->format('Y-m-d');
		$sql = "
			SELECT r.id
			FROM
				reservation r JOIN accepted_reservation ar
				ON r.id = ar.reservation_id
			WHERE
				r.couch_id = {$this->couch_id}
				AND r.id != {$this->id}
				AND (
					(r.from BETWEEN '{$from}' AND '{$till}') OR
					(r.till BETWEEN '{$from}' AND '{$till}') OR
					(r.from < '{$from}' AND r.till > '{$till}')
				)
		";
		return DataAccessObject::query($sql)->fetch_all(MYSQLI_ASSOC);
	}
	
	public function guestScore() {
		$sql = "
			SELECT score
			FROM guest_score
			WHERE reservation_id = $this->id
		";
		$result = DataAccessObject::query($sql);
		if ($result->num_rows):
			return $result->fetch_row()[0];
		endif;
		
		return false;
	}
	
	public function couchScore() {
		$sql = "
			SELECT score
			FROM couch_score
			WHERE reservation_id = $this->id
		";
		
		$result = DataAccessObject::query($sql);
		if ($result->num_rows):
			return $result->fetch_row()[0];
		endif;

		return false;
	}
}
