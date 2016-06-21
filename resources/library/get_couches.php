<?php
require_once 'functions.php';
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
header('Content-type: application/json');
echo json_encode(getCouchesPaginator($page));
?>
