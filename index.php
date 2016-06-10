<?php
session_start();
if (isset($_SESSION['user'])):
	require_once 'resources/library/functions.php';
	$email = $_SESSION['user'];
	$isPremium = isPremium($email);
	if (!$isPremium):
		include 'resources/templates/premium_modal.php';
	endif;
else:
	include 'resources/templates/signup_modal.php';
	include 'resources/templates/login_modal.php';
	include 'resources/templates/send_token_modal.php';
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
	<title>Couch Inn</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/jumbotron.css" rel="stylesheet">
	<link href="css/carousel.css" rel="stylesheet">
	<link href="css/sticky-footer-navbar.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>

<body>
	<!-- HEADER -->
	<?php include 'resources/templates/navbar.php'; ?>

	<!-- JUMBOTRON -->
	<?php if (!isset($email)): ?>
	<div class="jumbotron">
		<div class="container">
			<h1 class="text-center">¡Alójese con nativos<br />y conozca viajeros!</h1>
			<br />
			<p class="text-center">Con <strong>Couch Inn</strong> usted puede hospedarse con nativos del lugar en cada ciudad de Argentina, como así también abrir las puertas de su hogar a viajeros.
			Los usuarios comparten sus vidas con las personas que conocen, fomentando el intercambio cultural y el respeto mutuo.</p>
		</div>
	</div>
	<?php endif; ?>

	<!-- COUCHES -->
	<h1 class="text-center text-capitalize">Encuentre dónde hospedarse</h1>
	<hr />

		<!-- SEARCH -->
		<div class="container-fluid">
			<form class="col-md-6 col-centered" role="search">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="¿A dónde quieres ir?" name="q" disabled>
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit" disabled><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
			</form>
		</div>

		<!-- RESULT -->
		<div class="container marketing">
			<div id="couches-list" class="row"></div>
			<div id="arrows" class="row"></div>
		</div>

	<!-- FOOTER -->
	<?php include 'resources/templates/footer.php' ?>

	<script src="resources/library/jquery.min.js"></script>
	<script src="resources/library/bootstrap.min.js"></script>
	<script src="js/couches-list.js"></script>
	<script src="resources/library/moment-with-locales.min.js"></script>
	<script src="resources/library/validator.min.js"></script>
	<script src="js/fix-modal-navbar.js"></script>
	<?php
	if (!isset($email)):
		echo '<script src="js/login.js"></script>';
		echo '<script src="js/signup.js"></script>';
		echo '<script src="js/send_token.js"></script>';
	else:
		echo '<script src="resources/library/jquery.payment.min.js"></script>';
		echo '<script src="js/premium.js"></script>';
	endif;
	?>
</body>
</html>
