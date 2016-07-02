$('#datepicker').datepicker({
	startDate: "today",
	maxViewMode: 2,
	language: "es"
});

var $bookForm = $('#book-couch-form');
var $bookFormFeedback = $bookForm.find('.feedback');

/* FORM SUBMISSION */
$bookForm.submit(function($e) {
	$e.preventDefault();
	if (!$(this).find('input[type="submit"]').hasClass('disabled')) {
		$.post('resources/library/book_couch.php', $bookForm.serialize(), function(result) {
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