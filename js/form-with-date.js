moment.locale('es');
var $inputBirthdate = $('#input-birthdate');
var $inputDay		= $inputBirthdate.find('select[name="input-day"]');
var $inputMonth		= $inputBirthdate.find('select[name="input-month"]');
var $inputYear		= $inputBirthdate.find('select[name="input-year"]');

$('.form-with-date').submit(function ($e) {
	var validDate = false;
	var errorMessage;
	if ($inputDay.val() && $inputMonth.val() && $inputYear.val()) {
		$('.form-with-date').validator('destroy').validator();
		var date = moment($inputDay.val() + "-" + $inputMonth.val() + "-" + $inputYear.val(), "DD-MM-YYYY");
		if (!date.isValid()) {
			errorMessage = "Fecha inválida, vuelva a intentarlo.";
		}
		else if (moment().diff(date, 'years') < 18) {
			errorMessage = "Lo sentimos, debe ser mayor de 18 años.";
		} else {
			validDate = true;
		}
	}
	else {
		errorMessage = "Debe ingresar una fecha";
	}
	if (!validDate) {
		$('#input-birthdate').addClass('has-error');
		$('.date-error').text(errorMessage).show();
		$e.preventDefault();
	}
})
