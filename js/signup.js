var $form = $('#signup-form');

/* GENERATE DATE */
moment.locale('es');
var $inputBirthdate = $('#input-birthdate');
$.each(moment.months(), function(index, value) {
	var option = '<option value="' + (index + 1) + '">' + value + '</option>';
	$inputBirthdate.find('select[name="input-month"]').append(option);
});
for (var i = 1; i <= 31; i++) {
	option = '<option value="' + i + '">' + i + '</option>';
	$inputBirthdate.find('select[name="input-day"]').append(option);
}
for (var j = moment().year(); j >= moment().year() - 111; j--) {
	option = '<option value="' + j + '">' + j + '</option>';
	$inputBirthdate.find('select[name="input-year"]').append(option);
}

/* FORM VALIDATOR */
$form.validator({
	custom: {
		validatedate: function() {
			var $day = $inputBirthdate.find('select[name="input-day"]');
			var $month = $inputBirthdate.find('select[name="input-month"]');
			var $year = $inputBirthdate.find('select[name="input-year"]');
			var result = false;
			if ($day.val() && $month.val() && $year.val()) {
				$form.validator('destroy').validator();
				var date = moment($day.val() + "-" + $month.val() + "-" + $year.val(), "DD-MM-YYYY");
				if (!date.isValid()) {
					$('#date-error').text("Fecha inválida, vuelva a intentarlo.").show();
				}
				else if (moment().diff(date, 'years') < 18) {
					$('#date-error').text("Lo sentimos, debe ser mayor de 18 años.").show();
				}
				else {
					$('#date-error').hide();
					result = true;
				}
			}
			else {
				$('#date-error').text("Debe ingresar una fecha").show();
			}
			return result;
		}
	},
	errors: {
		validatedate: ' '
	}
});

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$form.validator('destroy').validator();
});

/* HIDE LOGIN MODAL */
$('#login-modal').on("click", "a", function() {
	$('#login-modal').modal('hide');
	var newUser = $('#login-modal').find('input[name="input-email"]').val();
	$('#input-email').val(newUser);
});
