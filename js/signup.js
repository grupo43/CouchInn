moment.locale('es');
var $inputBirthdate = $('#input-birthdate');
var $inputDay		= $inputBirthdate.find('select[name="input-day"]');
var $inputMonth		= $inputBirthdate.find('select[name="input-month"]');
var $inputYear		= $inputBirthdate.find('select[name="input-year"]');

var option = "";

/* GENERATE DATES */
	/* DAY */
	for (var i = 1; i <= 31; i++) {
		option = '<option value="' + i + '">' + i + '</option>';
		$inputDay.append(option);
	}

	/* MONTH */
	$.each(moment.months(), function(index, value) {
		option = '<option value="' + (index + 1) + '">' + value + '</option>';
		$inputMonth.append(option);
	});

	/* YEAR */
	for (var j = moment().year(); j >= moment().year() - 111; j--) {
		option = '<option value="' + j + '">' + j + '</option>';
		$inputYear.append(option);
	}

$('#signup-form').submit(function ($e) {
	/* VALIDATE BIRTHDATE */
	var validDate = isDateValid($inputDay.val(), $inputMonth.val(), $inputYear.val());
	if (!validDate.success) {
		$('#input-birthdate').addClass('has-error');
		$('.date-error').text(validDate.error).show();
		$e.preventDefault();
	} else {
		$('#input-birthdate').removeClass('has-error');
		$('.date-error').hide();
	}
});

/* HIDE LOGIN MODAL */
$('#login-modal').on("click", "#signup-suggest", function() {
	$('#login-modal').modal('hide');
	var newUser = $('#login-modal').find('input[name="input-email"]').val();
	$('#input-email').val(newUser);
});

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$('#signup-form').validator('destroy').validator();
});
