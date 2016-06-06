<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Tipos de Couches</strong></h3>
		</div>
		<div class="panel-body">
			<form class="form" id="couch-types-abm" action="/resources/library/couch_type_abm.php" method="post">
				<div class="form-group">
					<select name="couch-type-name" autocomplete="off"></select>
					<input class="confirm btn btn-danger" name="delete" value="Eliminar" type="submit" disabled="disabled" />
				</div>
				<div class="form-group">
					<input class="text-lowercase" name="new-value" placeholder="Nuevo valor" type="text" />
					<input class="btn btn-default" name="edit" value="Agregar" type="submit" disabled="disabled" />
				</div>
				<div id="abm-result" class="alert text-center" role="alert" hidden="hidden"></div>
			</form>
		</div>
	</div>
</div>