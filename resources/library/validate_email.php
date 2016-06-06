<?php
require_once 'functions.php';
$db = connect();

$email = $db->real_escape_string($_GET['input-email']);
$sql = "SELECT * FROM user
		WHERE email = '$email'";
if ($db->query($sql)->num_rows):
	header("HTTP/1.1 404 Direccion de email ya existente");
else:
	http_response_code(200);
endif;
?>