<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

session_start();
require_once 'resources/library/functions.php';
require_once 'resources/library/Reservation.php';

$from = implode('-', array_reverse(explode('/', $_POST['from'])));
$till = implode('-', array_reverse(explode('/', $_POST['till'])));
$data = array(
	'couch_id'		=> $_POST['couchID'],
	'guest'			=> $_SESSION['user'],
	'num_guests'	=> $_POST['numOfGuests'],
	'from'			=> $from,
	'till'			=> $till
);
$reservation = new Reservation($data);

if (!$reservation->reservationsAcceptedInSameRange()):
	$return = [
		"success" => true,
		"message" => "Se ha reservado el couch satisfactoriamente."
	];
else:
	$reservationDao = new DataAccessObject('reservation');
	$reservationDao->removeById($reservation->id);
	$return = [
		"success" => false,
		"message" => "Lo sentimos, el couch no se encuentra disponible en esas fechas."
	];
endif;

header('Content-Type: application/json');
echo json_encode($return);
