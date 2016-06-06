<div id="navbar" class="navbar-collapse collapse">
	<form id="login-form" class="navbar-form navbar-right" action="/resources/library/login.php" method="post">
		<div class="form-group">
			<input name="input-email" type="email" placeholder="Email" class="form-control" required>
		</div>
		<div class="form-group">
			<input name="input-password" type="password" placeholder="Contraseña" class="form-control" required>
		</div>
		<input name="access-level" value="user" type="hidden" />
		<button type="submit" class="tooltip-error btn btn-success" data-toggle="tooltip" data-placement="bottom" data-trigger="manual" title="Usuario o contraseña incorrecta">Iniciar sesión</button>
	</form>
</div>
<div class="tooltip" ></div>