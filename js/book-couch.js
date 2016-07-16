var updateDatePicker = function () {
	$.get('resources/library/couch_not_available_date.php', {couchID: $('#couchID').val()}, function(dates) {
		var now = new Date();
		var today = now.toLocaleDateString();
		$('#datepicker').datepicker('remove').datepicker({
			startDate: today,
			maxViewMode: 2,
			language: "es",
			datesDisabled: dates
		});
	});
};

updateDatePicker();

var $bookForm = $('#book-couch-form');
var $bookFormFeedback = $bookForm.find('.feedback');

/* FORM SUBMISSION */
$bookForm.submit(function($e) {
	$e.preventDefault();
	if (!$(this).find('input[type="submit"]').hasClass('disabled')) {
		$.post('/resources/library/book_couch.php', $bookForm.serialize(), function(result) {
			$bookFormFeedback.fadeOut(function() {
				if (result.success) {
					$bookFormFeedback.removeClass('alert-danger').addClass('alert-success');
				}
				else {
					$bookFormFeedback.removeClass('alert-success').addClass('alert-danger');
				}
				$bookFormFeedback.text(result.message).fadeIn();
			});
		});
	}
});

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$('#book-couch-form').validator('destroy').validator();
});

/* HIDE FEEDBACK AND CLEAR DATEPICKER WHEN MODAL IS CLOSED */
$('.modal').on('hidden.bs.modal', function() {
	$bookFormFeedback.hide();
	updateDatePicker();
});
