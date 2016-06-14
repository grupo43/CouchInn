<?php
if (!$_SERVER["REQUEST_METHOD"] == "POST"):
	header ('Location: /');
endif;

require 'edit-signup_input.php';

$sql = "INSERT INTO user (email, password, name, birthdate, phone_number)
		VALUES ('$inputEmail', PASSWORD('$inputPassword'), '$inputName', '$birthDate', '$phoneNumber')";
if ($db->query($sql)):
	session_start();
	$_SESSION['user'] = $inputEmail;
	header('Location: /');
endif;
?>
