<?php
session_start();
if (isset ($_GET['admin'])):
	unset($_SESSION['admin']);
elseif (isset ($_GET['user'])):
	unset($_SESSION['user']);	
endif;
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
