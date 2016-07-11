<?php
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['reservationID'])):
	header ('Location: /');
	exit;
endif;

session_start();
require_once 'resources/library/functions.php';
$db = connect();
$sql = "
	SELECT *
	FROM reservation
	WHERE id = {$_POST['reservationID']}
";
$reservation = $db->query($sql)->fetch_assoc();
$sql = "
	INSERT INTO accepted_reservation (reservation_id)
	VALUES ({$reservation['id']})
";
$db->query($sql);

$sql = "
	INSERT INTO denied_reservation (reservation_id)
	SELECT id
	FROM reservation AS r
	WHERE
		r.host_id = {$reservation['host_id']}
		AND r.id != {$reservation['id']}
		AND (
			(r.from BETWEEN '{$reservation['from']}' AND '{$reservation['till']}') OR
			(r.till BETWEEN '{$reservation['from']}' AND '{$reservation['till']}') OR
			(r.from < '{$reservation['from']}' AND r.till > '{$reservation['till']}')
		)
";
$db->query($sql);
emailReservation($reservation);
