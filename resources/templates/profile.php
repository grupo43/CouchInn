<?php
if (!isset ($_SESSION['user'])):
	header ('Location: /');
	exit;
endif;

require_once 'resources/library/functions.php';
$db = connect();
$sql = "
	SELECT score
	FROM guest_score
	WHERE reservation_id IN (
		SELECT id
		FROM reservation
		WHERE guest = '{$_SESSION['user']}'
	)
";
$userScore = 0;
$scores = $db->query($sql);
$numScores = $scores->num_rows;
if ($numScores):
	while ($score = $scores->fetch_row()[0]):
		$userScore += $score;
	endwhile;
	$userScore = round(($userScore / $numScores) * 2) / 2;
endif;
?>
<h1 class="page-header">Perfil</h1>
<div class="col-md-3">
	<div><img class="img-circle" src="https://placeholdit.imgix.net/~text?txtsize=24&txt=Foto de perfil&w=160&h=160" /></div>
	<br />
	<div>
		<input id="user-score" value="<?php echo $userScore ?>">
	</div>
</div>
<div class="col-md-4">
	<h4><strong>Nombre y Apellido:</strong> <?php echo $user['name'] ?></h4>
	<h4><strong>Nombre de Usuario:</strong> <?php echo $user['username'] ?></h4>
	<h4><strong>Email:</strong> <?php echo $user['email'] ?></h4>
	<h4><strong>Nacimiento:</strong> <?php echo implode('/', array_reverse(explode('-', $user['birthdate']))) ?></h4>
	<h4><strong>Teléfono:</strong> <?php echo $user['phone_number'] ?></h4>
	<br />
	<button class="btn btn-primary" data-toggle="modal" data-target="#edit-user-modal">Modificar datos</button>
</div>
