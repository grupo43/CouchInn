var $form = $('#premium-form');

/* FORM VALIDATOR */
$form.validator({
	custom: {
		validateexp: function($e) {
			var date = $form.find('[name="cardExpiry"]').val();
			var month = date.substr(0, 2);
			var year = date.substr(5);
			var result = false;
			if (year.length == 2 || year.length == 4) {
				var pattern = "MM-YYYY";
				if (year.length == 2) {
					pattern = "MM-YY";
				}
				date = moment(month + "-" + year, pattern);
				if (!date.isValid()) {
					$('#date-error').text("Fecha inválida, vuelva a intentarlo.").show();
				}
				else if (date.diff(moment(), 'month', true) < 0) {
					$('#date-error').text("Lo sentimos, la tarjeta está vencida.").show();
				}
				else {
					$('#date-error').hide();
					result = true;
				}
			}
			else {
				$('#date-error').text("Fecha inválida, vuelva a intentarlo.").show();
			}
			return result;
		},
		cardlength: function($e) {
			var length = $form.find('[name="cardNumber"]').val().replace(/ /g, '').length;
			if (length < 16) {
				$('#card-length-error').text("Ingrese los 16 caracteres").show();
				return false;
			}
			$('#card-length-error').hide();
			return true;
		}
	},
	errors: {
		validateexp: ' ',
		cardlength: ' '
	}
});

/* VALIDATE PAYMENT */
$form.submit(function($e) {
	$e.preventDefault();
	if (!$(this).find('button[type="submit"]').hasClass('disabled')) {
		$('#payment-result').fadeOut();
		$form.find('.subscribe').html('Validando Tarjeta <i class="fa fa-spinner fa-pulse"></i>').prop('disabled', true);
		window.setTimeout(function() {
			$.post('/resources/library/validate_card.php', function(result) {
				if (result.success) {
					$form.find('.subscribe').html('Pago exitoso <i class="fa fa-check"></i>').prop('disabled', true);
					window.setTimeout(function() {
						window.location.replace('/');
					}, 2000);
				}
				else {
					$('#payment-result').html(result.message).fadeIn();
					$form.find('.subscribe').html('Comprar Premium').prop('disabled', false);
				}
			});
		}, 2000);
	}
});

/* INPUTS FORMAT */
$('input[name=cardNumber]').payment('formatCardNumber');
$('input[name=cardCVC]').payment('formatCardCVC');
$('input[name=cardExpiry').payment('formatCardExpiry');

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$form.validator('destroy').validator();
});
