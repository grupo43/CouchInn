<?php
session_start();
if (isset($_SESSION['admin'])):
	header("Location: admin");
	exit;
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
	<title>Couch Inn - Admin Login</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/signin.css" rel="stylesheet">
</head>

<body>
	<img class="img-responsive center-block" src="img/logo/couchinn_logo_small.png" title="logo" alt="CouchInn Logo" />
	<div class="container">
		<form id="login-form" class="form-signin" action="/resources/library/login.php" method="post">
			<input name="input-email" type="email" class="form-control" placeholder="Email" required autofocus />
			<input name="input-password" type="password" class="form-control" placeholder="Contraseña" required />
			<input id="access-level" name="access-level" value="admin" type="hidden" />
			<button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
		</form>
		<div id="login-feedback" class="alert text-center" role="alert"></div>
	</div>

	<script src="resources/library/jquery-2.2.4.js"></script>
	<script src="resources/library/bootstrap.js"></script>
	<script src="js/login.js"></script>
</body>
</html>
