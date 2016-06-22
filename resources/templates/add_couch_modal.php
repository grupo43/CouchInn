<div id="add-couch-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="add-couch-form" class="form-horizontal" role="form" data-toggle="validator" enctype="multipart/form-data" action="/resources/library/add_couch.php" method="post">
				<div class="modal-header">
					<button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Publicar Couch</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="input-title" class="col-md-4 control-label">Título</label>
						<div class="col-md-8">
							<input id="input-title" class="form-control" name="input-title" type="text" maxlength="32" required />
							<p class="help-block with-errors"></p>
						</div>
					</div>
					<div class="form-group">
						<label for="input-description" class="col-md-4 control-label">Descripción</label>
						<div class="col-md-8">
							<textarea id="input-description" name="input-description" class="form-control" required></textarea>
							<p class="help-block with-errors"></p>
						</div>
					</div>
					<div class="form-group">
						<label for="couch-type" class="col-md-4 control-label">Tipo</label>
						<div class="col-md-8">
							<select class="form-control" name="couch-type" autocomplete="off" required>
								<option value="">-</option>
								<?php foreach (getCouchTypes() as $couchType): ?>
									<option value="<?php echo $couchType ?>"><?php echo ucfirst($couchType) ?></option>
								<?php endforeach; ?>
							</select>
							<p class="help-block with-errors"></p>
						</div>
					</div>
					<div class="form-group">
						<label for="input-capacity" class="col-md-4 control-label">Capacidad</label>
						<div class="col-md-8">
							<input class="form-control" name="input-capacity" type="number" min="1" required />
							<p class="help-block with-errors"></p>
						</div>
					</div>
					<div class="form-group">
						<label for="input-city" class="col-md-4 control-label">Ciudad</label>
						<div class="col-md-8">
							<input id="input-city" class="form-control" name="input-city" type="text" required />
							<p class="help-block with-errors"></p>
						</div>
					</div>
					<div class="form-group">
						<label for="input-images" class="col-md-4 control-label">Imágenes</label>
						<div class="col-md-8">
							<input id="input-images" name="input-images[]" type="file" multiple required />
							<p class="help-block small">Mínimo 3 / Máximo 5 (jpg/jpeg/png)</p>
						</div>
					</div>
					<div class="feedback-error alert alert-danger text-center" role="alert" hidden></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<input type="submit" class="btn btn-primary" value="Aceptar" />
				</div>
			</form>
		</div>
	</div>
</div>
