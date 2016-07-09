<?php
if (!isset($_GET['couchID'])):
	header('Location: /');
endif;

require_once 'functions.php';

header('Content-type: application/json');
echo json_encode(getOwner($_GET['couchID']));
?>
