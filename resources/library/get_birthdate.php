<?php 
require_once 'functions.php';
session_start();
$db = connect();
$sql = "
	SELECT birthdate FROM user
	WHERE username = '{$_SESSION['user']}'
";
if ($result = $db->query($sql)):
	$birthDate = strtotime($result->fetch_row()[0]);
	$day	= date("j", $birthDate);
	$month	= date("n", $birthDate);
	$year	= date("Y", $birthDate);
	$return = [
		"day"	=> $day,
		"month"	=> $month,
		"year"	=> $year
	];
endif;
header('Content-type: application/json');
echo json_encode($return);
?>
