<?php
session_start();
require_once 'functions.php';
$db = connect();

$inputUserName = $db->real_escape_string($_GET['input-username']);
$sql = "
	SELECT username FROM user
	WHERE username = '$inputUserName'
";
if ($db->query($sql)->num_rows):
	header("HTTP/1.1 404 Nombre de usuario ya existente");
	exit;
endif;
http_response_code(200);
?>
