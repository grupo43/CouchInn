<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

require_once 'functions.php';
$db = connect();
$inputEmail		= $db->real_escape_string($_POST['input-email']);
$inputPassword	= $db->real_escape_string($_POST['input-password']);
$inputName		= $db->real_escape_string($_POST['input-name']);
$inputYear		= $db->real_escape_string($_POST['input-year']);
$inputMonth		= $db->real_escape_string($_POST['input-month']);
$inputDay		= $db->real_escape_string($_POST['input-day']);
$birthDate		= $inputYear."-".$inputMonth."-".$inputDay;
$phoneNumber	= $db->real_escape_string($_POST['input-phone']);

$sql = "
	INSERT INTO user
		( email
		, password
		, name
		, birthdate
		, phone_number
		)
	VALUES
		( '$inputEmail'
		, PASSWORD('$inputPassword')
		, '$inputName'
		, '$birthDate'
		, '$phoneNumber'
		)
";
if ($db->query($sql)):
	session_start();
	$_SESSION['user'] = $inputEmail;
	header('Location: /');
endif;
?>
