<div class="modal fade" id="reset-password-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="send-token-form" class="form" role="form" action="/resources/library/send_token.php" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Recuperar contraseña</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="form-group">
								<input name="input-email" type="email" class="form-control" placeholder="Email" required autofocus />
							</div>
						</div>
						<div class="row">
							<div class="feedback alert text-center" role="alert" hidden="hidden"></div>
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
