<?php
session_start();
require_once 'resources/library/functions.php';
if (isset($_SESSION['user'])):
	if (!isPremium($_SESSION['user'])):
		include 'resources/templates/premium_modal.php';
	endif;
	include 'resources/templates/edit_user_modal.php';
else:
	include 'resources/templates/login_modal.php';
	include 'resources/templates/signup_modal.php';
	include 'resources/templates/send_token_modal.php';
endif;
?>