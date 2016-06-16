<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

require_once 'functions.php';
$db = connect();
$email = $db->real_escape_string($_POST['input-email']);
$newPassword = $db->real_escape_string($_POST['input-newpassword']);
$token = $db->real_escape_string($_POST['token']);
if (isValidToken($email, $token)):
	$sql = "
		UPDATE user
		SET password = PASSWORD('$newPassword')
		WHERE email = '$email'
	";
	if ($db->query($sql)):
		$return = ["success" => true, "message" => "Contraseña actualizada satisfactoriamente."];
	endif;
else:
	$return = ["success" => false, "message" => "Lo sentimos, el token es inválido o ha expirado."];
endif;
header('Content-type: application/json; charset=utf-8');
echo json_encode($return);
?>
