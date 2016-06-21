<?php
require_once 'functions.php';

header('Content-type: application/json');
echo json_encode(getCouchTypes());
?>
