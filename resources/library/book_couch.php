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
		FROM
			reservation r JOIN accepted_reservation ar
			ON r.id = ar.reservation_id
		WHERE `host_id` = '{$_POST['couchID']}'
	) AS accepted
	WHERE
		('$from' BETWEEN accepted.from AND accepted.till) OR
		('$till' BETWEEN accepted.from AND accepted.till) OR
		('$from' < accepted.from AND '$till' > accepted.till)
";

if (!$db->query($sql)->num_rows):
	$sql = "
		INSERT INTO reservation
			( `host_id`
			, `guest`
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
		"message" => "Se ha reservado el couch satisfactoriamente."
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
