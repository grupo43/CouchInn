<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

session_start();

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

$sql = "
	UPDATE user
	SET{$newData}
	WHERE username = '{$_SESSION['user']}'
";
if ($db->query($sql)):
	if (!empty($inputEmail)):
		$_SESSION['user'] = $inputEmail;
	endif;
	header('Location: /');
endif;
?>
