var $form = $('#login-form');
var $feedback = $('.feedback');

$form.submit(function($e) {
	$e.preventDefault();
	var formData = $(this).serialize();
	$.post('/resources/library/login.php', formData, function(result) {
		if (result.success) {
			var accessLevel = $('#access-level').val();
			window.location.reload();
		}
		else {
			$feedback.fadeOut(function() {
				$(this).removeClass('alert-success').addClass('alert-danger').html(result.message).fadeIn();
			});
		}
	});
});

$('.modal').on('hidden.bs.modal', function() {
	$feedback.fadeOut();
});
