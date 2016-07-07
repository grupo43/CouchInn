<?php 
session_start();

if (!isset($_SESSION['user'])):
	header ('Location: /');
	exit;
endif;

require_once 'resources/library/functions.php';
include 'resources/templates/includes.php';
$db = connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link rel="icon" href="img/favicon.ico">
	<title>Couch Inn - Admin Dashboard</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/dashboard.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>

<body>
	<!-- NAVBAR -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="/"><img src="img/logo/couchinn_logo_tiny.png" alt="Couchinn logo"/></a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if ($isPremium): echo '<i class="fa fa-star"></i> '; endif; echo $_SESSION['user'] ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#" data-toggle="modal" data-target="#add-couch-modal">Agregar couch</a></li>
						<?php if (!$isPremium): ?>
							<li><a href="" data-toggle="modal" data-target="#premium-modal">Ser Premium <i class="fa fa-star"></i></a></li>
						<?php endif; ?>
						<li role="separator" class="divider"></li>
						<li><a href="resources/library/logout.php?user">Cerrar sesión</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row">
			<!-- SIDEBAR -->
			<div class="col-md-2 sidebar">
				<ul class="nav nav-sidebar">
					<li <?php if (empty ($_GET)): echo 'class="active"'; endif; ?>><a href="user">Perfil</a></li>
					<li <?php if (isset ($_GET['myCouches'])): echo 'class="active"'; endif; ?>><a href="?myCouches" class="text-capitalize">Mis couches</a></li>
					<li <?php if (isset ($_GET['requestsIn'])): echo 'class="active"'; endif; ?>><a href="?requestsIn" class="text-capitalize">Solicitudes recibidas</a></li>
					<li <?php if (isset ($_GET['requestsOut'])): echo 'class="active"'; endif; ?>><a href="?requestsOut" class="text-capitalize">Solicitudes realizadas</a></li>
					<li <?php if (isset ($_GET['couchVisited'])): echo 'class="active"'; endif; ?>><a href="?couchVisited" class="text-capitalize">Couches que visité</a></li>
				</ul>
			</div>

			<!-- BODY -->
			<div class="main col-md-10 col-md-offset-2">
				<?php
				//-- PROFILE --//
				if (empty ($_GET)):
					include 'resources/templates/profile.php';
				endif;

				//-- MY COUCHES --//
				if (isset ($_GET['myCouches'])):
					include 'resources/templates/my_couches.php';
				endif;

				//-- REQUESTS --//
				if (isset ($_GET['requestsIn'])):
					include 'resources/templates/requestsIn.php';
				elseif (isset ($_GET['requestsOut'])):
					include 'resources/templates/requestsOut.php';
				endif;

				//-- VISITED --//
				if (isset ($_GET['couchVisited'])):
					include 'resources/templates/couchVisited.php';
				endif;
				?>
			</div>
		</div>
	</div>

	<script src="resources/library/jquery-2.2.4.js"></script>
	<script src="resources/library/bootstrap.js"></script>
	<script src="resources/library/functions.js"></script>
	<script src="resources/library/moment-with-locales.js"></script>
	<script src="resources/library/validator.js"></script>
	<script src="js/edit-user-data.js"></script>
	<script src="js/add-couch.js"></script>
	<?php if (!$isPremium): ?>
		<script src="resources/library/jquery.payment.js"></script>
		<script src="js/premium.js"></script>
	<?php endif; ?>
</body>
</html>
