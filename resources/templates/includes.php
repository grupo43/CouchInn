<?php
if (isset($_SESSION['user'])):
	$isPremium = isPremium($_SESSION['user']);
	if (!$isPremium):
		include 'resources/templates/premium_modal.php';
	endif;
	include 'resources/templates/edit_user_modal.php';
	include 'resources/templates/add_couch_modal.php';
else:
	include 'resources/templates/login_modal.php';
	include 'resources/templates/signup_modal.php';
	include 'resources/templates/send_token_modal.php';
endif;
?>
