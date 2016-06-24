<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

session_start();
require_once 'resources/library/functions.php';
$db = connect();

parse_str($_POST['formData']);
$photos = $_POST['photos'];
$sql = "
	INSERT INTO couch
		( owner
		, title
		, description
		, type
		, city
		, capacity
		)
	VALUES
		( '{$_SESSION['user']}'
		, '$inputTitle'
		, '$inputDescription'
		, '$couchType'
		, '$inputCity'
		, '$inputCapacity'
		)
";
if ($db->query($sql)):
	$couchID = $db->insert_id;
	$sql = "INSERT INTO couch_picture (";
	$columns = "couch_id,";
	$values = "'$couchID',";
	for ($i = 0; $i < count($photos); $i++):
		$columns .= "picture".($i+1).",";
		$values .= "'$photos[$i]',";
	endfor;
	$columns = substr($columns, 0, -1); // Remove last comma
	$values = substr($values, 0, -1); // Remove last comma
	$sql .= $columns . ")";
	$sql .= " VALUES (" . $values . ")";
	if ($db->query($sql)):
		echo $couchID;
	endif;
endif;
?>
