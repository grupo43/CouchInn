<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

$answer = stripslashes($_POST['answer']);

require_once 'resources/library/functions.php';
$db = connect();

$sql = "
	UPDATE `q&a`
	SET answer = '$answer'
	WHERE id = {$_POST['questionID']}
";
$db->query($sql);
?>
