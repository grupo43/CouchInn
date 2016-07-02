var $form = $('#login-form');
var $loginFeedback = $('#login-feedback');

$form.submit(function($e) {
	$e.preventDefault();
	var formData = $(this).serialize();
	$.post('/resources/library/login.php', formData, function(result) {
		if (result.success) {
			window.location.reload();
		}
		else {
			$loginFeedback.fadeOut(function() {
				$(this).removeClass('alert-success').addClass('alert-danger').html(result.message).fadeIn();
			});
		}
	});
});

$('.modal').on('hidden.bs.modal', function() {
	$loginFeedback.fadeOut();
});
