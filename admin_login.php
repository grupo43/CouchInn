<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<link rel="icon" href="img/favicon.ico">
		<title>Couch Inn - Admin Login</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/signin.css" rel="stylesheet">
	</head>

	<body>
		<img class="img-responsive center-block" src="img/logo/couchinn_logo_small.png" title="logo" alt="CouchInn Logo" />
		<div class="container">
			<form id="login-form" class="form-signin" action="/resources/library/login.php" method="post">
				<label for="input-email" class="sr-only">Email</label>
				<input name="input-email" type="email" class="form-control" placeholder="Email" required autofocus />
				<label for="input-password" class="sr-only">Contraseña</label>
				<input name="input-password" type="password" class="form-control" placeholder="Contraseña" required />
				<input name="access-level" value="admin" type="hidden" />
				<button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
			</form>
			<div class="login-error alert alert-danger text-center" role="alert" hidden="hidden"></div>
		</div>

		<!--  JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="resources/library/jquery.min.js"></script>
		<script src="resources/library/bootstrap.min.js"></script>
	</body>
</html>