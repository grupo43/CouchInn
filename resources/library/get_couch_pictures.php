<?php
if (!isset ($_GET['id'])):
	header ('Location: /');
	exit;
endif;

require_once 'resources/library/functions.php';

header ('Content-Type: application/json');
echo json_encode(getPictures($_GET['id']));
?>
