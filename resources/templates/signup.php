<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="signup-form" class="form-horizontal" role="form" action="/resources/library/signup.php" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Registro</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="input-name" class="col-md-4 control-label">Nombre</label>
		    			<div class="col-md-8">
							<input name="input-name" type="text" class="form-control" id="input-name" required />
		    			</div>
					</div>
					<div class="form-group has-feedback">
						<label for="input-email" class="col-md-4 control-label">Email</label>
		    			<div class="col-md-8">
							<input name="input-email" type="email" class="form-control" id="input-email" required data-remote="/resources/library/validate_email.php" />
		   					<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
		    				<div class="help-block with-errors"></div>
		    			</div>
					</div>
					<div class="form-group" id="input-birthdate">
						<label class="col-md-4 control-label">Fecha de nacimiento</label>
	    				<div class="col-md-8">
	    					<select name="input-day" data-validatedate="validatedate" required >
	 							<option value="">Día</option>
	 						</select>
	    					<select name="input-month" data-validatedate="validatedate" required >
	 							<option value="">Mes</option>
	 						</select>
	    					<select name="input-year" data-validatedate="validatedate" required >
	 							<option value="">Año</option>
	 						</select>
							<div id="date-error" class="error" hidden="hidden"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-phone" class="col-md-4 control-label">Número de teléfono</label>
		    			<div class="col-md-8">
							<input name="input-phone" type="text" class="form-control" id="input-phone" data-minlength="10" pattern="[0-9]+" required />
		    				<div class="help-block">Sólo números (al menos 10)</div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-password" class="col-md-4 control-label">Contraseña</label>
		    			<div class="col-md-8">
							<input name="input-password" type="password" data-minlength="6" class="form-control" id="input-password" required />
	      					<div class="help-block">Al menos 6 caracteres</div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-password-confirm" class="col-md-4 control-label">Confirme la contraseña</label>
		    			<div class="col-md-8">
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