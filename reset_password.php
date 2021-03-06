<?php
if (!isset ($_GET['email']) || !isset ($_GET['token'])):
	header('Location: /');
	exit;
endif;
require_once 'resources/library/functions.php';
$db = connect();

$email = $db->real_escape_string($_GET['email']);
$token = $db->real_escape_string($_GET['token']);
if (!isValidToken ($email, $token)):
	echo '<script>';
		echo 'alert("Lo sentimos, el token es inválido o ha expirado");';
		echo "window.location.replace('/');";
	echo '</script>';
endif;
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link rel="icon" href="img/favicon.ico">
	<title>Couch Inn - Restablecer Contraseña</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/jumbotron-narrow.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="header">
			<a href="/"><img alt="Couch Inn logo" src="img/logo/couchinn_logo_tiny.png" /></a>
		</div>

		<div class="jumbotron">
			<form id="reset-password-form" class="form-horizontal" action="/resources/library/reset_password.php" data-toggle="validator" method="post">
				<div class="form-group">
					<label class="control-label col-md-4">Email</label>
					<div class="col-md-8">
						<input name="input-email" class="form-control text-center" value="<?php echo $email ?>" readonly />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">Contraseña</label>
					<div class="col-md-4">
						<input id="input-newpassword" name="input-newpassword" class="form-control" type="password" data-minlength="6" placeholder="Contraseña nueva" data-error="Al menos 6 caracteres" required />
						<div class="help-block with-errors"></div>
					</div>
					<div class="col-md-4">
						<input name="input-password-confirm" class="form-control" type="password" data-match="#input-newpassword" data-match-error="Las contraseñas no coinciden" placeholder="Confirmar contraseña" required />
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<input name="token" value="<?php echo $token ?>" type="hidden" />
				<input class="col-md-offset-4 btn btn-success" value="Cambiar contraseña" type="submit" required />
			</form>
		</div>
		<div class="feedback alert alert-success text-center" role="alert" hidden></div>

		<footer class="footer">
			<p>&copy; 2016 Couch Inn</p>
		</footer>
	</div>

	<script src="resources/library/jquery-2.2.4.js"></script>
	<script src="resources/library/validator.js"></script>
	<script>
		$('#reset-password-form').submit(function($e) {
			$e.preventDefault();
			if (!$(this).find('input[type="submit"]').hasClass('disabled')) {
				var formData = $(this).serialize();
				$.post('/resources/library/reset_password.php', formData, function(result) {
					$feedback = $('.feedback');
					if (result.success) {
						$feedback.addClass('alert-success');
					}
					else {
						$feedback.addClass('alert-danger');
					}
					$feedback.html(result.message).fadeIn();
					window.setTimeout(function() {
						window.location.replace('/');
					}, 2000);
				});
			}
		});
	</script>
</body>
</html>
