<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

require_once 'functions.php';
$db = connect();
$email = $db->real_escape_string($_POST['input-email']);
$password = $db->real_escape_string($_POST['input-password']);
$accessLevel = $db->real_escape_string($_POST['access-level']);
$sql = "SELECT * FROM $accessLevel
		WHERE email = '$email'";
if (!$db->query($sql)->num_rows):
	if ($accessLevel == 'user'):
		$result = ["success" => false, "message" => 'Lo sentimos, no existe una cuenta asociada a esa dirección de email.</br >Si lo desea, puede <a id="signup-suggest" href="javascript:void(0)" data-toggle="modal" data-target="#signup-modal">registrarse</a>.'];
	elseif ($accessLevel == 'admin'):
		$result = ["success" => false, "message" => 'Email o contraseña incorrecta. Verifique los datos ingresados y vuelva a intentarlo.'];
	endif;
else:
	$sql = "SELECT email, password
			FROM $accessLevel
			WHERE email = '$email' AND password = PASSWORD('$password')";
	if ($db->query($sql)->num_rows):
		session_start();
		$_SESSION["$accessLevel"] = $email;
		$result = ["success" => true];
	else:
		if ($accessLevel == 'user'):
			$message = 'Contraseña incorrecta. ';
		elseif ($accessLevel == 'admin'):
			$message = 'Email o contraseña incorrecta. ';
		endif;
		$message .= 'Verifique los datos ingresados y vuelva a intentarlo.';
		if ($accessLevel == 'user'):
			$message .= '<br />Si lo desea, puede <a id="send-token" href="resources/library/send_token.php?input-email='.$email.'">restablecer su contraseña</a>.';
		endif;
		$result = ["success" => false, "message" => $message];
	endif;
endif;
header('Content-type: application/json; charset=utf-8');
echo json_encode($result);
?>
