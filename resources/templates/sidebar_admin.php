<div class="col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li <?php if (empty ($_GET)): echo 'class="active"'; endif; ?>><a href="admin">Inicio</a></li>
		<li <?php if (isset ($_GET['database'])): echo 'class="active"'; endif; ?>><a href="?database">Base de Datos</a></li>
		<li <?php if (isset ($_GET['reports'])): echo 'class="active"'; endif; ?>><a href="?reports">Reportes</span></a></li>
	</ul>
</div>
