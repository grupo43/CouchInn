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
		UPDATE couch
		SET enabled = 
	";
	$sql .= (isCouchEnabled($couchID))?"0":"1"; // enabled->disabled | disabled->enabled
	$sql .= " WHERE id = '$couchID'";
	$db->query($sql);
endif;
header ('Location: /');
?>
