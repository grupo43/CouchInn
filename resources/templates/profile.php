<?php
if (!isset ($_SESSION['user'])):
	header ('Location: /');
	exit;
endif;

require_once 'resources/library/functions.php';
$db = connect();
$userScore = userScore($_SESSION['user']);
if ($userScore):
	$userScore = round(($userScore * 2)) / 2;
endif;
?>
<h1 class="page-header">Perfil</h1>
<div class="col-md-3">
	<div><img class="img-circle" src="https://placeholdit.imgix.net/~text?txtsize=24&txt=Foto de perfil&w=160&h=160" /></div>
	<br />
	<div>
		<input class="display-only-score" value="<?php echo $userScore ?>">
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
