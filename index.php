<?php
require_once 'resources/library/functions.php';

session_start();
if (isset($_SESSION['user'])):
	$email = $_SESSION['user'];
	$isPremium = isPremium($email);
	if (!$isPremium):
		include 'resources/templates/premium_payment.php';
	endif;
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
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<!-- HEADER -->
		<?php include 'resources/templates/header_user.php'; ?>

		<!-- JUMBOTRON -->
		<?php
		if (!isset($email)):
			include 'resources/templates/jumbotron.php';
		endif;
		?>

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

		<!--	JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
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
		else:
			echo '<script src="resources/library/jquery.payment.min.js"></script>';
			echo '<script src="js/payment.js"></script>';
		endif;
		?>
	</body>
</html>
