<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_GET['id'])):
	header ('Location: /');
	exit;
else:
	$couchID = $_GET['id'];
endif;

require_once 'resources/library/functions.php';
$db = connect();
if (isOwner($_SESSION['user'], $couchID)): // If the couch exists and the logged user is the owner..
	$sql = "
		SELECT couch_id
		FROM reservation
		WHERE couch_id = '$couchID'
	";
	if ($db->query($sql)->num_rows): // There are pending reservations
		$sql = "
			UPDATE couch
			SET enabled = 0
		";
		$disabled = true;
	else:
		$sql = "DELETE FROM couch";
		$disabled = false;
	endif;
	$sql .= " WHERE id = '$couchID'";
	if ($db->query($sql)):
		header('Content-Type: application/json');
		echo json_encode(["disabled" => $disabled]);
	endif;
else:
	header ('Location: /');
endif;
?>
