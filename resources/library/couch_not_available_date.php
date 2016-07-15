<?php
if (!isset ($_GET['couchID'])):
	header ('Location: /');
	exit;
endif;

$couchID = $_GET['couchID'];

require_once 'resources/library/functions.php';
$db = connect();
$sql = "
	SELECT
		`from`, till
	FROM
		reservation r JOIN accepted_reservation ar
		ON r.id = ar.reservation_id
	WHERE
		couch_id = $couchID AND CURDATE() <= `till`
";

$notAvailableDays = array();
$dates = $db->query($sql);
if ($dates->num_rows):
	$today = new DateTime('today');
	while ($date = $dates->fetch_assoc()):
		$till = new DateTime($date['till']);
		$till = $till->modify('+1 day');
		$period = new DatePeriod(
			new DateTime($date['from']),
			new DateInterval('P1D'),
			$till
		);
		foreach ($period as $day):
			if ($day >= $today):
				$notAvailableDays[] = $day->format('d/m/Y');
			endif;
		endforeach;
	endwhile;
endif;

header ('Content-Type: application/json');
echo json_encode($notAvailableDays);
