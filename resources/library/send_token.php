<?php
if (isset($_GET['email'])):
	require_once 'functions.php';
	$db = connect();
	$email = $db->real_escape_string($_GET['email']);
	$sql = "SELECT * FROM user
			WHERE email = '$email'";
	$result = $db->query($sql);
	if ($result->num_rows):
		$token = generateToken($email);
		$subject = "Couch Inn - Restablecimiento de contraseña";
		$url = 'reset_password.php?email='.$email.'&token='.$token;
		$body = '
			<html>
				<body>
					<p>Hola <strong>'.$result->fetch_assoc()['name'].'</strong>,<br />recibimos una solicitud para restablecer su contraseña.</p>
					<p>Para completar el procedimiento ingrese al siguiente enlace:<br /><a href="http://localhost/'.$url.'">www.couchinn.com/'.$url.'</a></p>
					</p>
					<p>Saludos,<br /><em>Couch Inn</em>.</p>
				</body>
			</html>
		';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: "Couch Inn" <couchinn@couch.com>';
		if (mail($email, $subject, $body, $headers)):
			$return = ["success" => true, "message" => "Se ha envíado un email a $email con las instrucciones para restablecer su contraseña."];
		else:
			$return = ["success" => false, "message" => "Lo sentimos, ha ocurrido un error. Vuelva a intentarlo más tarde."];
		endif;
	else:
		$return = ["success" => false, "message" => "Lo sentimos, no existe ninguna cuenta asociada a la dirección de email ingresada."];
	endif;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($return);
else:
	header('Location: /');
endif;
?>
