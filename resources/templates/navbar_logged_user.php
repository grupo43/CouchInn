<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if ($isPremium): echo '<i class="fa fa-star"></i> '; endif; echo $email ?> <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="#">Perfil</a></li>
			<li><a href="#">Mensajes</a></li>
			<?php if (!$isPremium): ?>
				<li><a href="" data-toggle="modal" data-target="#myModal">Ser Premium <i class="fa fa-star"></i></a></li>
			<?php endif; ?>
			<li role="separator" class="divider"></li>
			<li><a href="resources/library/logout.php?user">Cerrar sesión</a></li>
		</ul>
	</li>
</ul>