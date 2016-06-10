<?php
require_once 'functions.php';
$db = connect();

$sql = "SELECT * FROM couch_type
		WHERE enabled = 1
		ORDER BY name";
$result = $db->query($sql);
$couch_types = array();
while ($row = $result->fetch_assoc()):
	$couch_types[] = $row['name'];
endwhile;
header('Content-type: application/json; charset=utf-8');
echo json_encode($couch_types);
?>
