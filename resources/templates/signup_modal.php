<div id="signup-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="signup-form" class="form-horizontal" data-toggle="validator" role="form" action="/resources/library/signup.php" method="post">
				<div class="modal-header">
					<button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Registrarse</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="input-name" class="col-md-3 control-label">Nombre</label>
						<div class="col-md-9">
							<input type="text" name="input-name" id="input-name" class="form-control" required />
						</div>
					</div>
					<div class="form-group has-feedback">
						<label for="input-email" class="col-md-3 control-label">Email</label>
						<div class="col-md-9">
							<input type="email" name="input-email" id="input-email" class="form-control" data-remote="/resources/library/validate_email.php" required />
							<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group" id="input-birthdate">
						<label class="col-md-3 control-label">Fecha de nacimiento</label>
						<div class="col-md-9">
							<select name="input-day" required>
								<option value="" class="text-center">- Día -</option>
							</select>
							<select name="input-month" required>
								<option value="" class="text-center">- Mes -</option>
							</select>
							<select name="input-year" required>
								<option value="" class="text-center">- Año -</option>
							</select>
							<div class="error date-error" hidden="hidden"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-phone" class="col-md-3 control-label">Número de teléfono</label>
						<div class="col-md-9">
							<input type="text" name="input-phone" id="input-phone" class="form-control" data-minlength="10" pattern="[0-9]+" required />
							<div class="help-block">Sólo números (al menos 10)</div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-password" class="col-md-3 control-label">Contraseña</label>
						<div class="col-md-9">
							<input name="input-password" type="password" data-minlength="6" class="form-control" id="input-password" required />
							<div class="help-block">Al menos 6 caracteres</div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-password-confirm" class="col-md-3 control-label">Confirme la contraseña</label>
						<div class="col-md-9">
							<input type="password" class="form-control" id="input-password-confirm" data-match="#input-password" data-match-error="Las contraseñas no coinciden" required />
							<div class="help-block with-errors"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<input type="submit" class="btn btn-primary" value="Aceptar" />
				</div>
			</form>
		</div>
	</div>
</div>
