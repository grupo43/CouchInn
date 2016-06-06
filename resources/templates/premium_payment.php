<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="payment-form" class="form credit-card-box" role="form" action="/resources/library/validate_card.php" method="post">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Pago de servicio Premium<img class="pull-right" src="/img/credit-cards.png"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group col-md-12">
						<label for="cardNumber">Número de tarjeta</label>
						<div class="input-group">
							<input class="form-control" name="cardNumber" data-cardlength="cardlength" required />
							<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
						</div>
						<div id="card-length-error" class="error" hidden="hidden"></div>
					</div>
					<div class="form-group col-md-12">
						<label for="cardOwner">Titular de la tarjeta</label>
						<input class="form-control" name="cardOwner" required />
		    			<div class="help-block with-errors"></div>
					</div>
					<div class="form-group col-md-6">
						<label for="cardExpiry">Fecha de caducidad</label>
						<input class="form-control" name="cardExpiry" placeholder="MM / AA" data-validateexp="validateexp" required />
						<div id="date-error" class="error" hidden="hidden"></div>
					</div>
					<div class="form-group col-md-6">
						<label for="cardCVC">Código CVC</label>
						<input class="form-control" name="cardCVC" data-minlength="3" data-minlength-error="No es lo suficientemente largo" required />
		    			<div class="help-block with-errors"></div>
					</div>
					<div class="form-group col-md-12">
						<button id="amount" class="form-control" disabled><strong>$150</strong></button>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<div id="payment-result" class="alert alert-danger text-center" role="alert" hidden="hidden"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button class="subscribe btn btn-success" type="submit">Comprar Premium</button>
				</div>
			</form>
		</div>
	</div>
</div>