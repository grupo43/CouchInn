<?php
session_start();
require_once 'functions.php';
$db = connect();

$inputEmail = $db->real_escape_string($_GET['input-email']);
$sql = "
	SELECT email FROM user
	WHERE email = '$inputEmail'
";
if ($db->query($sql)->num_rows):
	header("HTTP/1.1 404 Direccion de email ya existente");
	exit;
endif;
http_response_code(200);
?>
