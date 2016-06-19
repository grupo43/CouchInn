<?php
if (!isset($_GET['input-password'])):
	header ('Location: /');
	exit;
endif;

session_start();
require_once 'functions.php';
$db = connect();
$sql = "
	SELECT email
	FROM user
	WHERE
		email = '{$_SESSION['user']}' AND password = PASSWORD('{$_GET['input-password']}')
";
if ($db->query($sql)->num_rows):
	$result = ["success" => true];
else:
	$result = ["success" => false];
endif;
header('Content-type: application/json');
echo json_encode($result);
?>
