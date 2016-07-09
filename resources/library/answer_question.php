<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"):
	header ('Location: /');
	exit;
endif;

session_start();
require_once 'resources/library/functions.php';
$db = connect();
$answer = stripslashes($_POST['answer']);

$sql = "
	UPDATE `q&a`
	SET answer = '$answer'
	WHERE id = {$_POST['questionID']}
";
$db->query($sql);
echo $_SESSION['user'];
?>
