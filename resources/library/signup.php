<?php
require_once 'functions.php';
if($_SERVER["REQUEST_METHOD"] == "POST"):
	$db = connect();

	$email = $db->real_escape_string($_POST['input-email']);
	$password = $db->real_escape_string($_POST['input-password']);
	$name = $db->real_escape_string($_POST['input-name']);
	$birthDate = $_POST['input-year']."-".$_POST['input-month']."-".$_POST['input-day'];
	$phoneNumber = $db->real_escape_string($_POST['input-phone']);
	
	$sql = "INSERT INTO user (email, password, name, birthdate, phone_number)
			VALUES ('$email', PASSWORD('$password'), '$name', '$birthDate', '$phoneNumber')";
	if ($db->query($sql)):
		session_start();
	    $_SESSION['user'] = $email;
		header('Location: /');
	endif;
endif;
?>
