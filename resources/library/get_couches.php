<?php
require_once 'functions.php';
$page	= (isset($_GET['page'])) ? $_GET['page'] : 1;
header('Content-type: application/json');
if (isset($_GET['sql'])):
	echo json_encode(getCouchesPaginator($page, $_GET['sql']));
else:
	echo json_encode(getCouchesPaginator($page));
endif;
?>
