<?php 
session_start();
if (!isset ($_SESSION['admin'])):
	header("Location: admin_login");
	exit;
endif;

require_once 'resources/library/functions.php';
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
	<link href="css/bootstrap-datepicker3.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>

<body>
	<!-- NAVBAR -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="admin"><img src="img/logo/couchinn_logo_tiny.png" alt="Couchinn logo"/></a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['admin'] ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Ayuda</a></li>
						<li><a href="#">Mensajes</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="resources/library/logout.php?admin">Cerrar sesión</a></li>
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
					<li <?php if (empty ($_GET)): echo 'class="active"'; endif; ?>><a href="admin">Inicio</a></li>
					<li <?php if (isset ($_GET['database'])): echo 'class="active"'; endif; ?>><a href="?database">Base de Datos</a></li>
					<li <?php if (isset ($_GET['reports'])): echo 'class="active"'; endif; ?>><a href="?reports">Reportes</span></a></li>
				</ul>
			</div>

			<!-- BODY -->
			<div class="main col-md-10 col-md-offset-2">
			<?php
			//-- DASHBOARD --//
			if (empty ($_GET)):
				include 'resources/templates/dashboard.php';
			endif;

			//-- DATABASE --//
			if (isset ($_GET['database'])):
				include 'resources/templates/database.php';
			endif;

			//-- REPORTS --//
			if (isset ($_GET['reports'])):
				include 'resources/templates/reports.php';
			endif;
			?>
			</div>
		</div>
	</div>

	<script src="resources/library/jquery-2.2.4.js"></script>
	<script src="resources/library/bootstrap.js"></script>
	<script src="resources/library/functions.js"></script>
	<script src="js/reports.js"></script>
	<script src="resources/library/bootstrap-datepicker.js"></script>
	<script src="resources/locales/bootstrap-datepicker.es.min.js"></script>
	<script>
		$('#datepicker').datepicker({
			maxViewMode: 2,
			language: "es"
		});
	</script>
	<script src="js/couch-type-abm.js"></script>
</body>
</html>
