<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

session_start();
require_once 'resources/library/functions.php';
$db = connect();

$from = implode('/', array_reverse(explode('/', $_POST['from'])));
$till = implode('/', array_reverse(explode('/', $_POST['till'])));

$sql = "
	SELECT *
	FROM (
		SELECT `from`, till
		FROM reservation
		WHERE couch_id = '{$_POST['couchID']}' AND id IN (SELECT reservation_id FROM accepted_reservation)
	) AS accepted
	WHERE
		(DATE('{$from}') BETWEEN accepted.from AND accepted.till) OR
		(DATE('{$till}') BETWEEN accepted.from AND accepted.till) OR
		(DATE('{$from}') < accepted.from AND DATE('{$till}') > accepted.till)
";

if (!$db->query($sql)->num_rows):
	$sql = "
		INSERT INTO reservation
			( couch_id
			, user
			, num_guests
			, `from`
			, till
			)
		VALUES
			( {$_POST['couchID']}
			, '{$_SESSION['user']}'
			, {$_POST['numOfGuests']}
			, DATE('{$from}')
			, DATE('{$till}')
			)
	";
	$db->query($sql);
	$return = [
		"success" => true,
		"message" => "Se ha reservado el couch satifactoriamente."
	];
else:
	$return = [
		"success" => false,
		"message" => "Lo sentimos, el couch no se encuentra disponible en esas fechas."
	];
endif;

header('Content-Type: application/json');
echo json_encode($return);
?>
