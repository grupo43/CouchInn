<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Tipos de Couches</strong></h3>
		</div>
		<div class="panel-body">
			<form class="form" id="couch-type-abm-form" action="/resources/library/couch_type_abm.php" method="post">
				<div class="form-group row">
					<div class="col-md-8">
						<select class="form-control" name="couch-type-name" autocomplete="off">
							<option value="">-</option>
							<?php foreach (getCouchTypes() as $couchType): ?>
								<option value="<?php echo $couchType ?>"><?php echo $couchType ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-4">
						<input class="confirm btn btn-danger" name="delete" value="Eliminar" type="submit" disabled="disabled" />
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-8">
						<input class="form-control text-lowercase" name="new-value" placeholder="Nuevo valor" type="text" />
					</div>
					<div class="col-md-4">
						<input class="btn btn-default" name="edit" value="Agregar" type="submit" disabled="disabled" />
					</div>
				</div>
				<div class="feedback alert text-center" role="alert" hidden="hidden"></div>
			</form>
		</div>
	</div>
</div>
