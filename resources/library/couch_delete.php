<?php
session_start();
if (!isset($_GET['id']) || !isset($_SESSION['user'])):
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
