
<?php
if (!isset ($_GET['id'])):
	header ('Location: /');
	exit;
endif;

session_start();
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

if (isset($_SESSION['user'])):
	if ($_SESSION['user'] == $couch['owner']):
		include 'resources/templates/edit_couch_modal.php';
	else:
		include 'resources/templates/book_couch_modal.php';
	endif;
endif;

$sql = "
	SELECT AVG(score)
	FROM
		host_score hs JOIN reservation r
		ON hs.reservation_id = r.id
	WHERE host_id = $id
";
$couchScore = $db->query($sql)->fetch_row()[0];
if ($couchScore):
	$couchScore = round(($couchScore * 2)) / 2;
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
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker3.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/carousel.css" rel="stylesheet">
	<link href="css/sticky-footer-navbar.css" rel="stylesheet">
	<link href="css/star-rating.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>
<body>
	<!-- HEADER -->
	<?php include 'resources/templates/navbar.php' ?>
	
	<!-- CAROUSEL -->
	<?php include 'resources/templates/couch_ph_carousel.php' ?>

	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div id="couch-delete-toggle-feedback" class="feedback alert text-center" role="alert" hidden></div>
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
	<div class="container-fluid">
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
					<a class="btn btn-info btn-block" data-toggle="modal" data-target="#edit-couch-modal">Modificar</a>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<br />
	<!-- QUESTIONS & ANSWERS -->
	<div class="container-fluid">
		<div class="row">
			<fieldset class="col-md-offset-2 col-md-8">
				<legend>Preguntas y respuestas</legend>
				<?php if (isset($_SESSION['user']) && ($_SESSION['user'] != $couch['owner'])): ?>
					<div class="row">
						<form id="add-question" action="/resources/library/add_question.php" method="POST">
							<div class="col-md-offset-1 col-md-9">
								<input class="form-control" name="question" type="text" placeholder="Escriba su pregunta.." required />
							</div>
							<input name="couchID" value="<?php echo $couch['id'] ?>" type="hidden" />
							<input class="btn btn-primary col-md-1" type="submit" value="Enviar" />
						</form>
					</div>
					<br />
				<?php endif; ?>
				<ul id="questions" class="row">
				<?php if ($questions): ?>
					<?php foreach ($questions as $question): ?>
						<li><i class="fa fa-comment" aria-hidden="true"></i> <strong><?php echo $question['user'] ?>: </strong><?php echo $question['question'] ?></li>
						<?php if ($question['answer']): ?>
						<ul>
							<li><i class="fa fa-comments" aria-hidden="true"></i> <strong><?php echo $couch['owner'] ?>: </strong><?php echo $question['answer'] ?></li>
						</ul>
						<br />
						<?php elseif (isset($_SESSION['user']) && ($_SESSION['user'] == $couch['owner'])): ?>
						<ul>
							<li>
								<form class="answer-question" action="/resources/library/answer_question.php" method="POST">
									<div class="col-md-10">
										<input type="text" name="answer" class="form-control" placeholder="Escriba su respuesta.." />
									</div>
									<input name="questionID" value="<?php echo $question['id'] ?>" type="hidden">
									<input name="couchID" value="<?php echo $couch['id'] ?>" type="hidden" />
									<input class="btn btn-primary" type="submit" value="Enviar" />
								</form>
							</li>
						</ul>
						<?php else: ?>
						<br />
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				</ul>
			</fieldset>
		</div>
	</div>

	<!-- FOOTER -->
	<?php include 'resources/templates/footer.php' ?>

	<script src="resources/library/jquery-2.2.4.js"></script>
	<script src="resources/library/bootstrap.js"></script>
	<script src="resources/library/script.js"></script>
	<script src="resources/library/bootstrap-datepicker.js"></script>
	<script src="resources/locales/bootstrap-datepicker.es.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
	<script src="resources/library/moment-with-locales.js"></script>
	<script src="resources/library/validator.js"></script>
	<script src="resources/library/star-rating.js"></script>
	<script src="resources/library/couch-delete-toggle.js"></script>
	<script src="js/fix-modal-navbar.js"></script>
	<?php if (!isset($_SESSION['user'])): ?>
		<script src="js/login.js"></script>
		<script src="js/signup.js"></script>
		<script src="js/send-token.js"></script>
	<?php else: ?>
		<?php if ($_SESSION['user'] == $couch['owner']): ?>
			<script src="js/edit-couch.js"></script>
			<script src="js/answer-question.js"></script>
		<?php else: ?>
			<script src="js/add-question.js"></script>
			<script src="js/book-couch.js"></script>
		<?php endif; ?>
		<script src="js/edit-user-data.js"></script>
		<script src="js/add-couch.js"></script>
		<?php if (!$isPremium): ?>
			<script src="resources/library/jquery.payment.js"></script>
			<script src="js/premium.js"></script>
		<?php endif; ?>
		<script src="resources/library/functions.js"></script>
	<?php endif; ?>
	<script>
		$("#couch-score").rating({
			size: 'xs',
			displayOnly: true
		});
	</script>
</body>
</html>
