<?php
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['reservationID'])):
	header ('Location: /');
	exit;
endif;

require_once 'resources/library/functions.php';
$db = connect();
$sql = "
	INSERT INTO denied_reservation (reservation_id)
	VALUES ({$_POST['reservationID']})
";
$db->query($sql);
?>
