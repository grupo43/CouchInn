<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a href="/"><img alt="Couch Inn logo" src="img/logo/couchinn_logo_tiny.png" /></a>
		</div>
		<?php
		if (isset($_SESSION['user'])):
			include 'resources/templates/navbar_user.php';
		else:
		?>
			<div class="navbar-form navbar-right">
				<button class="btn btn-success" data-toggle="modal" data-target="#login-modal">Iniciar sesión</button>
				<button class="btn btn-primary" data-toggle="modal" data-target="#signup-modal">Registrarse</button>
			</div>
		<?php endif; ?>
	</div>
</nav>
