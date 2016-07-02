<?php
session_start();
require_once 'resources/library/functions.php';
include 'resources/templates/includes.php';
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
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/jumbotron.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker3.css" rel="stylesheet">
	<link href="css/carousel.css" rel="stylesheet">
	<link href="css/sticky-footer-navbar.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>

<body>
	<!-- HEADER -->
	<?php include 'resources/templates/navbar.php' ?>

	<!-- JUMBOTRON -->
	<?php if (!isset($_SESSION['user'])): ?>
	<div class="jumbotron">
		<div class="container">
			<h1 class="text-center">¡Alójese con nativos<br />y conozca viajeros!</h1>
			<br />
			<p class="text-center">Con <strong>Couch Inn</strong> usted puede hospedarse con nativos del lugar en cada ciudad de Argentina, como así también abrir las puertas de su hogar a viajeros.
			Los usuarios comparten sus vidas con las personas que conocen, fomentando el intercambio cultural y el respeto mutuo.</p>
		</div>
	</div>
	<?php endif; ?>

	<!-- COUCHES HEAD -->
	<h1 class="text-center text-capitalize">Encuentre dónde hospedarse</h1>
	<hr />

	<!-- SEARCH -->
	<div class="container-fluid">
		<div class="col-md-offset-2 col-md-8">
			<form id="search-form" class="form-horizontal" role="search">
				<div class="form-group">
					<div class="col-md-3">
						<select class="form-control" name="couchType" autocomplete="off">
							<option value="">Tipo de couch</option>
							<?php foreach (getCouchTypes() as $couchType): ?>
								<option value="<?php echo $couchType ?>"><?php echo ucfirst($couchType) ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-6">
						<div id="datepicker" class="input-daterange input-group" >
							<input type="text" class="input form-control" name="from" />
							<span class="input-group-addon">hasta</span>
							<input type="text" class="input form-control" name="till" />
						</div>
					</div>
					<div class="col-md-3">
						<input class="form-control" name="inputCapacity" type="number" min="1" placeholder="Capacidad mínima" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input name="search" class="form-control" placeholder="Título o descripción .." type="text" />
					</div>
					<div class="col-md-2">
						<button class="form-control btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> <strong>Buscar</strong> </button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- RESULT -->
	<div class="container marketing">
		<?php $couchesPaginator = getCouchesPaginator(1) ?>
		<div id="couches-list" class="row"><?php echo $couchesPaginator['couches'] ?></div>
		<div id="arrows" class="row"><?php echo $couchesPaginator['arrows'] ?></div>
	</div>

	<!-- FOOTER -->
	<?php include 'resources/templates/footer.php' ?>

	<script src="resources/library/jquery-2.2.4.js"></script>
	<script src="resources/library/bootstrap.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
	<script src="resources/library/functions.js"></script>
	<script src="resources/library/script.js"></script>
	<script src="resources/library/bootstrap-datepicker.js"></script>
	<script src="resources/locales/bootstrap-datepicker.es.min.js"></script>
	<script src="resources/library/moment-with-locales.js"></script>
	<script src="resources/library/validator.js"></script>
	<script src="js/couches-list.js"></script>
	<script src="js/fix-modal-navbar.js"></script>
	<?php if (!isset($_SESSION['user'])): ?>
		<script src="js/login.js"></script>
		<script src="js/signup.js"></script>
		<script src="js/send-token.js"></script>
	<?php else: ?>
		<script src="js/edit-user-data.js"></script>
		<script src="js/add-couch.js"></script>
		<?php if (!$isPremium): ?>
			<script src="resources/library/jquery.payment.js"></script>
			<script src="js/premium.js"></script>
		<?php endif; ?>
	<?php endif; ?>
</body>
</html>
