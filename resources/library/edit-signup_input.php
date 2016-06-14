<?php
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
?>
