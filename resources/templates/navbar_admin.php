<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<a href="admin.php"><img src="img/logo/couchinn_logo_tiny.png" alt="Couchinn logo"/></a>
		</div>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $email ?> <span class="caret"></span></a>
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