<div class="modal fade" id="login-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="login-form" class="form-horizontal" role="form" action="/resources/library/login.php" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Iniciar sesión</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="input-email" class="col-md-4 control-label">Email</label>
						<div class="col-md-8">
							<input name="input-email" type="email" class="form-control" required autofocus />
						</div>
					</div>
					<div class="form-group">
						<label for="input-password" class="col-md-4 control-label">Contraseña</label>
						<div class="col-md-8">
							<input name="input-password" type="password" class="form-control" required />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-8 pull-right">
							<a id="password-forgot-question" class="small" href="javascript:void(" data-toggle="modal" data-target="#reset-password-modal">¿Olvidaste tu contraseña?</a>
						</div>
					</div>
					<input id="access-level" name="access-level" value="user" hidden />
					<div class="feedback alert text-center" role="alert" hidden="hidden"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<input type="submit" class="btn btn-primary" value="Aceptar" />
				</div>
			</form>
		</div>
	</div>
</div>
