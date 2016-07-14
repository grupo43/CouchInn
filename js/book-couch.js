$('#datepicker').datepicker({
	startDate: "tomorrow",
	maxViewMode: 2,
	language: "es"
	// TODO: Disable not available dates
	// datesDisabled: ['06/07/2016', '21/07/2016']
});
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
	$bookForm.validator('destroy').validator();
});
