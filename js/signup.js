var option = "";

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

/* RESET FORM WHEN MODAL GETS HIDDEN */
$('.modal').on('hidden.bs.modal', function() {
	$('#signup-form').trigger('reset');
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
