<?php
require_once 'functions.php';

$from = "";
$to = "";
if (isset ($_GET['from']) && isset($_GET['to'])):
	$from = implode('/', array_reverse(explode('/', $_GET['from'])));
	$to = implode('/', array_reverse(explode('/', $_GET['to'])));
endif;

header('Content-type: application/json');
echo json_encode(getPremiumSales($from, $to));
?>
