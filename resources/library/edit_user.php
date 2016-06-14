<?php
if (!$_SERVER["REQUEST_METHOD"] == "POST"):
	header ('Location: /');
endif;

session_start();
$email = $_SESSION['user'];

require 'edit-signup_input.php';

$newData = "";
if (!empty($inputEmail)):
	$newData .= " email = '$inputEmail',";
endif;
if (!empty($inputPassword)):
	$newData .= " password = PASSWORD('$inputPassword'),";
endif;
if (!empty($inputName)):
	$newData .= " name = '$inputName',";
endif;
if (!empty($phoneNumber)):
	$newData .= " phone_number = '$phoneNumber',";
endif;
$newData .= " birthdate = '$birthDate'";

$sql = "UPDATE user SET" . $newData . " WHERE email = '$email'";
if ($db->query($sql)):
	if (!empty($inputEmail)):
		$_SESSION['user'] = $inputEmail;
	endif;
	header('Location: /');
endif;
?>
