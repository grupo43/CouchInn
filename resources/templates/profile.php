<h1 class="page-header">Perfil</h1>
<div class="col-md-3">
	<img class="img-circle" src="https://placeholdit.imgix.net/~text?txtsize=33&txt=Puntaje&w=160&h=160" />
</div>
<div class="col-md-4">
	<h4><strong>Nombre:</strong> <?php echo $user['name'] ?></h4>
	<h4><strong>Email:</strong> <?php echo $user['email'] ?></h4>
	<h4><strong>Nacimiento:</strong> <?php echo $user['birthdate'] ?></h4>
	<h4><strong>Teléfono:</strong> <?php echo $user['phone_number'] ?></h4>
	<br />
	<button class="btn btn-primary" data-toggle="modal" data-target="#edit-user-modal">Modificar datos</button>
</div>
