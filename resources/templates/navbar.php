<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a href="/"><img alt="Couch Inn logo" src="img/logo/couchinn_logo_tiny.png" /></a>
		</div>
		<?php if (isset($_SESSION['user'])): ?>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if ($isPremium): echo '<i class="fa fa-star"></i> '; endif; echo $_SESSION['user'] ?> <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="user">Perfil</a></li>
					<li><a href="#" data-toggle="modal" data-target="#add-couch-modal">Agregar couch</a></li>
					<?php if (!$isPremium): ?>
						<li><a href="" data-toggle="modal" data-target="#premium-modal">Ser Premium <i class="fa fa-star"></i></a></li>
					<?php endif; ?>
					<li role="separator" class="divider"></li>
					<li><a href="resources/library/logout.php?user">Cerrar sesión</a></li>
				</ul>
			</li>
		</ul>
		<?php else: ?>
			<div class="navbar-form navbar-right">
				<button class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Iniciar sesión</button>
				<button class="btn btn-default" data-toggle="modal" data-target="#signup-modal">Registrarse</button>
			</div>
		<?php endif; ?>
	</div>
</nav>
