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

$newData = "";
if (!empty($inputTitle)):
	$newData .= " title = '$inputTitle',";
endif;
if (!empty($inputDescription)):
	$newData .= " description = '$inputDescription',";
endif;
if (!empty($inputCity)):
	$newData .= " city = '$inputCity',";
endif;
if (!empty($inputCapacity)):
	$newData .= " capacity = '$inputCapacity',";
endif;
$newData .= " type = '$couchType'";

$sql = "
	UPDATE couch
	SET{$newData}
	WHERE id = '$id'
";
if ($db->query($sql)):
	$newPictures = "";
	for ($i = 0; $i < count($photos); $i++):
		$newPictures .= "picture".($i+1)." = '$photos[$i]',";
	endfor;
	for ($j = count($photos); $j < 5; $j++):
		$newPictures .= "picture".($j+1)." = NULL,";	
	endfor;
	$newPictures = substr($newPictures, 0, -1); // Remove last comma
	$sql = "
		UPDATE couch_picture
		SET {$newPictures}
		WHERE couch_id = '$id'
	";
	echo $sql;
	$db->query($sql);
endif;
?>
