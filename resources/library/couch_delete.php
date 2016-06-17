<?php
if (!isset($_GET['id'])):
	header ('Location: /');
	exit;
else:
	$couchID = $_GET['id'];
endif;

session_start();

require_once 'resources/library/functions.php';
$db = connect();
$sql = "
	SELECT id
	FROM couch
	WHERE id = '$couchID' AND owner = '{$_SESSION['user']}'
";
$result = $db->query($sql);
if ($result->num_rows): // If the couch exists and the logged user is the owner..
	$sql = "
		SELECT couch_id
		FROM reservation
		WHERE accepted = 0
	";
	if ($db->query($sql)->num_rows): // There are pending reservations
		$sql = "
			UPDATE couch
			SET enabled = 0
		";
	else:
		$sql = "DELETE FROM couch";
	endif;
	$sql .= " WHERE id = '$couchID'";
	$db->query($sql);
endif;
header ('Location: /');
?>
