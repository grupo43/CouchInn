<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

require_once 'functions.php';
$db = connect();
session_start();

if (mt_rand(0,1)):
	$sql = "
		INSERT INTO payment (user)
		VALUES ('{$_SESSION['user']}')
	";
	if ($db->query($sql)):
		$result = ["success" => true];
	else:
		$result = [
			"success" => false,
			"message" => "Ha ocurrido un error inesperado.<br />Comuníquese con el soporte técnico."
		];
	endif;
else:
	$result = [
		"success" => false,
		"message" => "Tarjeta inválida.<br />Por favor, verifique los datos y vuelva a intentarlo."
	];
endif;

header('Content-type: application/json');
echo json_encode($result);
?>
