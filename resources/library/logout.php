<?php
session_start();
if (isset ($_GET['admin'])):
	unset($_SESSION['admin']);
	header("Location: /admin_login.php");
elseif (isset ($_GET['user'])):
	unset($_SESSION['user']);
	header("Location: /");
endif;
?>