$.getJSON('/resources/library/get_birthdate.php', function(birthdate) {
	var option = "";

	/* DAY */
	for (var i = 1; i < birthdate.day; i++) {
		option = '<option value="' + i + '">' + i + '</option>';
		$inputDay.append(option);
	}
	option = '<option value="' + i + '" selected>' + i + '</option>';
	$inputDay.append(option);
	for (var i = (parseInt(birthdate.day) + 1); i <= 31; i++) {
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
	for (var j = (parseInt(birthdate.month) + 1); j <= 12; j++) {
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
	for (var k = (parseInt(birthdate.year) - 1); k >= moment().year() - 111; k--) {
		option = '<option value="' + k + '">' + k + '</option>';
		$inputYear.append(option);
	}
});

$('#input-password').keyup(function() {
	if ($(this).length) {
		$('#input-password-confirm').prop('required', 'required'); // Ask for password confirmation if user enters a new password
	}
})

/* RESET FORM WHEN MODAL GETS HIDDEN */
$('.modal').on('hidden.bs.modal', function() {
	$('#edit-user-form').trigger('reset');
});

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$('#edit-user-form').validator('destroy').validator();
});
