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
	SELECT enabled
	FROM couch
	WHERE id = '$couchID' AND owner = '{$_SESSION['user']}'
";
$result = $db->query($sql);
if ($result->num_rows): // If the couch exists and the logged user is the owner..
	$sql = "
		UPDATE couch
		SET enabled = 
	";
	$sql .= ($result->fetch_assoc()['enabled'])?"0":"1"; // enabled->disabled | disabled->enabled
	$sql .= " WHERE id = '$couchID'";
	$db->query($sql);
endif;
header ('Location: /');
?>
