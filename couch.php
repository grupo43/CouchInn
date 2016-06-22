<?php
if (!isset ($_GET['id'])):
	header ('Location: /');
	exit;
endif;

require_once 'resources/library/functions.php';
$db = connect();	
$id = $db->real_escape_string($_GET['id']);

$sql = "
	SELECT *
	FROM couch
	WHERE id = '$id'
";
$result = $db->query($sql);
if (!$result->num_rows): // There is no couch with that ID
	header ('Location: /');
	exit;
else:
	session_start();
	$couch = $result->fetch_assoc();
	if (!$couch['enabled'] && (!isset($_SESSION['user']) || !isOwner($_SESSION['user'], $id))):
		// The couch is disabled and the user trying to access it isn't the owner
		header ('Location: /');
		exit;
	endif;
endif;

include 'resources/templates/includes.php';

$pictures	= getPictures($id);
$questions	= getQuestions($id);
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
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/carousel.css" rel="stylesheet">
	<link href="css/sticky-footer-navbar.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>
<body>
	<!-- HEADER -->
	<?php include 'resources/templates/navbar.php' ?>
	
	<!-- CAROUSEL -->
	<?php include 'resources/templates/couch_ph_carousel.php' ?>

	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="feedback alert alert-info text-center" role="alert" hidden></div>
		</div>
	</div>
	<!-- COUCH DATA -->
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<ul class="list-inline center-block text-center">
				<li class="col-md-4"><strong>Tipo</strong><br /><?php echo ucfirst($couch['type']) ?></li>
				<li class="col-md-4"><strong>Capacidad</strong><br /><?php echo $couch['capacity'] ?> huéspedes</li>
				<li class="col-md-4"><strong>Ubicación</strong><br /><?php echo $couch['city'] ?></li>
			</ul>
		</div>
	</div>
	<hr />
	<!-- COUCH DESCRIPTION -->
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<h4 class="text-"><?php echo $couch['description'] ?></h4>
		</div>
		<!-- COUCH MANAGEMENT BUTTONS -->
		<?php if (isset($_SESSION['user']) && ($_SESSION['user'] == $couch['owner'])): ?>
		<div class="col-md-2 pull-right">
			<div class="col-md-12">
				<a id="delete-couch" class="btn btn-danger btn-block" href="/resources/library/couch_delete.php?id=<?php echo $id ?>">Eliminar</a>
				<a id="toggle-couch" href="/resources/library/couch_toggle.php?id=<?php echo $id ?>" class="btn btn-block 
				<?php if ($couch['enabled']): ?>
					btn-warning">Deshabilitar
				<?php else: ?>
					btn-success">Habilitar
				<?php endif; ?>
				</a>
				<a href="javascript:void(0)" class="btn btn-info btn-block">Modificar</a>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<!-- QUESTIONS & ANSWERS -->
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
			<?php if ($questions): ?>
				<ul>
				<?php foreach ($questions as $question): ?>
					<li><?php echo $question['question'] ?></li>
					<ul>
					<?php if ($question['answer']): ?>
						<li><?php echo $question['answer'] ?></li>
					<?php elseif (isset($_SESSION['user']) && ($_SESSION['user'] == $couch['owner'])): ?>
						<input type="text" placeholder="Escriba su respuesta" />
						<button class="btn btn-primary">Responder</button>
					<?php endif; ?>
					</ul>
				<?php endforeach; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- FOOTER -->
	<?php include 'resources/templates/footer.php' ?>
	
	<script src="resources/library/jquery.min.js"></script>
	<script src="resources/library/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
	<script src="resources/library/moment-with-locales.min.js"></script>
	<script src="resources/library/validator.min.js"></script>
	<script src="resources/library/couch-delete-toggle.js"></script>
	<script src="js/couch.js"></script>
	<script src="js/fix-modal-navbar.js"></script>
	<?php if (!isset($_SESSION['user'])): ?>
		<script src="js/login.js"></script>
		<script src="js/signup.js"></script>
		<script src="js/send-token.js"></script>
	<?php else: ?>
		<script src="js/edit-user-data.js"></script>
		<script src="js/add-couch.js"></script>
		<?php if (!$isPremium): ?>
			<script src="resources/library/jquery.payment.min.js"></script>
			<script src="js/premium.js"></script>
		<?php endif; ?>
	<?php endif; ?>
</body>
</html>
