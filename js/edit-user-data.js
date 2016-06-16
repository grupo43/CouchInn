moment.locale('es');
var $inputBirthdate = $('#input-birthdate');
var $inputDay		= $inputBirthdate.find('select[name="input-day"]');
var $inputMonth		= $inputBirthdate.find('select[name="input-month"]');
var $inputYear		= $inputBirthdate.find('select[name="input-year"]');

/* GET AND LOAD CURRENT USER BIRTHDATE */
$.getJSON('/resources/library/get_birthdate.php', function(birthdate) {
	var option = "";

	/* DAY */
	for (var i = 1; i < birthdate.day; i++) {
		option = '<option value="' + i + '">' + i + '</option>';
		$inputDay.append(option);
	}
	option = '<option value="' + i + '" selected>' + i + '</option>';
	$inputDay.append(option);
	for (i = (parseInt(birthdate.day) + 1); i <= 31; i++) {
		option = '<option value="' + i + '">' + i + '</option>';
		$inputDay.append(option);
	}

	/* MONTH */
	for (var j = 1; j < birthdate.month; j++) {
		option = '<option value="' + j + '">' + moment.months()[j-1] + '</option>';
		$inputMonth.append(option);
	}
	option = '<option value="' + birthdate.month + '" selected>' + moment.months()[birthdate.month-1] + '</option>';
	$inputMonth.append(option);
	for (j = (parseInt(birthdate.month) + 1); j <= 12; j++) {
		option = '<option value="' + j + '">' + moment.months()[j-1] + '</option>';
		$inputMonth.append(option);
	}

	/* YEAR */
	for (var k = moment().year(); k > birthdate.year; k--) {
		option = '<option value="' + k + '">' + k + '</option>';
		$inputYear.append(option);
	}
	option = '<option value="' + k + '" selected>' + k + '</option>';
	$inputYear.append(option);
	for (k = (parseInt(birthdate.year) - 1); k >= moment().year() - 111; k--) {
		option = '<option value="' + k + '">' + k + '</option>';
		$inputYear.append(option);
	}
});

$('#edit-user-form').submit(function ($e) {
	$e.preventDefault();

	/* VALIDATE BIRTHDATE */
	var validDate = isDateValid($inputDay.val(), $inputMonth.val(), $inputYear.val());
	if (!validDate.success) {
		$('#input-birthdate').addClass('has-error');
		$('.date-error').text(validDate.error).show();
	} else {
		$('#input-birthdate').removeClass('has-error');
	}

	/* VALIDATE CURRENT PASSWORD */
	var validPassword = false;
	var currentPassword = $('#input-current-password').val();
	if (currentPassword.length) {
		$.getJSON('/resources/library/validate_password.php?input-password='+currentPassword, function(result) {
			if (!result.success) {
				$('#input-current-password-group').addClass('has-error');
				$('#input-current-password-group').find('.help-block').text('Contraseña incorrecta').show();
			} else {
				$('#input-current-password-group').removeClass('has-error');
			}

			if (!$('#edit-user-form').find('.has-error').length && !$('#edit-user-form').find('input[type=submit]').hasClass('disabled')) {
				$.post('/resources/library/edit_user.php', $('#edit-user-form').serialize());
				$('#edit-user-modal').modal('hide');
			}
		});
	}
});

$('#input-password').keyup(function() {
	if ($(this).val().length) {
		$('#input-password-confirm').prop('required', true); // Ask for password confirmation if user enters a new password
	} else {
		$('#input-password-confirm').prop('required', false);
	}
});

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$('#edit-user-form').validator('destroy').validator();
});
