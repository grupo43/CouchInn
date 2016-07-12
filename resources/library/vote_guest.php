<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

session_start();
require_once 'resources/library/functions.php';
$db = connect();

$sql = "
	INSERT INTO guest_score
	VALUES
		( {$_POST['reservationID']}
		, {$_POST['score']}
		, '{$_POST['input-comment']}'
	  	)
";
if ($db->query($sql)):
	header ('Location: http://couchinn.com/user?requestsIn');
endif;
