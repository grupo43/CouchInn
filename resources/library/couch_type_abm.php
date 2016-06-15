<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

require_once 'functions.php';
$db = connect();

if (isset ($_POST['edit'])):
	$newValue = strtolower($db->real_escape_string($_POST['new-value']));
	$sql = "SELECT * FROM couch_type
			WHERE name = '$newValue'";
	$result = $db->query($sql);

	// ADD
	if (empty ($_POST['couch-type-name'])):
		$sql = "INSERT INTO couch_type (name)
				VALUES ('$newValue')
				ON DUPLICATE KEY UPDATE enabled=1";
		if ($result->num_rows):
			if ($result->fetch_assoc()['enabled']):
				$sql = "";
				$return = [
					"success" => false,
					"message" => "El valor '$newValue' ya existe"
				];
			else:
				$return = [
					"success" => true,
					"message" => "Valor '$newValue' habilitado<br />(existen couches de este tipo)"
				];
			endif;
		else:
			$return = [
				"success" => true,
				"message" => "Valor '$newValue' añadido satisfactoriamente"
			];
		endif;

	// EDIT
	else:
		$couchTypeName = $_POST['couch-type-name'];
		$sql = "UPDATE couch_type
				SET name = '$newValue'
				WHERE name = '$couchTypeName'";
		if ($result->num_rows):
			$sql = "";
			if ($result->fetch_assoc()['enabled']):
				$return = [
					"success" => false,
					"message" => "El valor '$newValue' ya existe"
				];
			else:
				$return = [
					"success" => false,
					"message" => "El valor '$newValue' ya existe pero está deshabilitado"
				];
			endif;
		else:
			$return = [
				"success" => true,
				"message" => "El valor se ha modificado satisfactoriamente"
			];
		endif;
	endif;

// DELETE
elseif (isset ($_POST['delete'])):
	$couchTypeName = $_POST['couch-type-name'];
	$sql = "SELECT * FROM couch
			WHERE type = '$couchTypeName'";
	$result = $db->query($sql);
	if (!$result->num_rows):
		$sql = "DELETE FROM couch_type
				WHERE name = '$couchTypeName'";
		$return = [
			"success" => true,
			"message" => "Valor '$couchTypeName' eliminado satisfactoriamente"
		];
	else:
		$sql = "UPDATE couch_type
				SET enabled = 0
				WHERE name = '$couchTypeName'";
		$return = [
			"success" => true,
			"message" => "Valor '$couchTypeName' deshabilitado<br />(existen couches de este tipo)"
		];
	endif;
endif;

if ($sql && !$db->query($sql)):
	$return = [
		"success" => false,
		"message" => "Ha ocurrido un error inesperado.<br />Comuníquese con el soporte técnico"
	];
endif;


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);
?>
