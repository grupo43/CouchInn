<div class="modal fade" id="give-score-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="score-form" class="form-horizontal" role="form" action="/resources/library/vote_guest.php" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Puntuar huésped</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="score" class="col-md-3 control-label">Puntaje</label>
						<div class="col-md-9">
							<input class="score" name="score" type="number" value="5" required />
						</div>
					</div>
					<div class="form-group">
						<label for="input-comment" class="col-md-3 control-label">Comentario</label>
						<div class="col-md-9">
							<textarea name="input-comment" type="password" class="form-control" placeholder="Ingrese un comentario sobre su huésped .." required></textarea>
						</div>
					</div>
					<input id="reservationID" name="reservationID" type="hidden" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<input type="submit" class="btn btn-primary" value="Aceptar" />
				</div>
			</form>
		</div>
	</div>
</div>
