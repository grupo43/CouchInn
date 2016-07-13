<?php
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['reservationID'])):
	header ('Location: /');
	exit;
endif;

session_start();
require_once 'resources/library/Reservation.php';

$reservation = Reservation::withId($_POST['reservationID']);
$reservation->accept();
emailReservation($reservation);
