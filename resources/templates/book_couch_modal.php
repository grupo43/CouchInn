<div id="book-couch-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="book-couch-form" class="form-horizontal" role="form" data-toggle="validator" enctype="multipart/form-data" action="/resources/library/book_couch.php" method="post">
				<div class="modal-header">
					<button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Reservar Couch</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="col-md-6 text-center">
							<label for="datepicker">Días de reserva</label>
						</div>
						<div class="col-md-6 text-center">
							<label for="couch-capacity">Cantidad de huéspedes</label>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<div id="datepicker" class="input-daterange input-group" >
								<input type="text" class="input form-control" name="from" required />
								<span class="input-group-addon">hasta</span>
								<input type="text" class="input form-control" name="till" required />
							</div>
						</div>
						<div class="col-md-6">
							<select id="num-guests" class="form-control text-center" name="numOfGuests" autocomplete="off" required>
								<option value="">Seleccione una cant.</option>
								<?php for ($i = 1; $i <= $couch['capacity']; $i++): ?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
								<?php endfor; ?>
							</select>
						</div>
					</div>
					<div class="feedback alert text-center" role="alert" hidden></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<input type="submit" class="btn btn-primary" value="Aceptar" />
				</div>
				<input name="couchID" value="<?php echo $couch['id'] ?>" type="hidden" />
			</form>
		</div>
	</div>
</div>
