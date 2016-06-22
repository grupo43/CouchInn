<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

session_start();
require_once 'resources/library/functions.php';
$db = connect();

$imagesCount = count($_FILES['input-images']['name']);
if ($imagesCount >= 3 && $imagesCount <= 5):
	$validextensions = ["jpeg", "jpg", "png"];
	$images = array();
	for ($i = 0; $i < $imagesCount; $i++):
		$tmp = explode('.', basename($_FILES['input-images']['name'][$i]));
		$ext = end($tmp); // File $i extension
		if (!in_array($ext, $validextensions)):
			$return = [
				"success" => false,
				"message" => "Todos los archivos deben ser imágenes (jpg/jpeg/png)"
			];
			header ('Content-Type: application/json');
			echo json_encode($return);
			exit;
		endif;
	endfor;
else:
	$return = [
		"success" => false,
		"message" => "Debe subir 3, 4 ó 5 imágenes"
	];
	header ('Content-Type: application/json');
	echo json_encode($return);
	exit;
endif;

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
		, '{$_POST['input-title']}'
		, '{$_POST['input-description']}'
		, '{$_POST['couch-type']}'
		, '{$_POST['input-city']}'
		, '{$_POST['input-capacity']}'
		)
";
if ($db->query($sql)):
	$couch_id = $db->insert_id;
	$folder = $_SERVER['DOCUMENT_ROOT']."/img/couches/couch{$couch_id}";
	mkdir($folder);
	$sql = "INSERT INTO couch_picture (";
	$columns = "couch_id,";
	$values = "'$couch_id',";
	for ($i = 0; $i < $imagesCount; $i++):
		$fileName = basename($_FILES['input-images']['name'][$i]);
		$tmp = explode('.', $fileName);
		$ext = end($tmp); // File $i extension
		$columns .= "picture".($i+1).",";
		$values .= "'".($i+1).".{$ext}',";
		move_uploaded_file($_FILES['input-images']['tmp_name'][$i], "$folder/".($i+1).".{$ext}");
	endfor;
	$columns = substr($columns, 0, -1); // Remove last comma
	$values = substr($values, 0, -1); // Remove last comma
	$sql .= $columns . ")";
	$sql .= " VALUES (" . $values . ")";
	if ($db->query($sql)):
		$return = [
			"success" => true,
			"id" => $couch_id
		];
		header ('Content-Type: application/json');
		echo json_encode($return);
	endif;
endif;
?>
