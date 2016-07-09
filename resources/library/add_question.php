<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

session_start();
require_once 'functions.php';
$db = connect();
$question = stripslashes($_POST['question']);

$sql = "
	INSERT INTO `q&a`
		( `user`
		, couch_id
		, question		
		)
	VALUES
		( '{$_SESSION['user']}'
		, {$_POST['couchID']}
		, '$question'
		)
";
$db->query($sql);
?>
