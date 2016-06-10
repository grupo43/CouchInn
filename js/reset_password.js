$('#reset-password-form').submit(function($e) {
	$e.preventDefault();
	console.log('test');
	if (!$(this).find('input[type="submit"]').hasClass('disabled')) {
		var formData = $(this).serialize();
		$.post('/resources/library/reset_password.php', formData, function(result) {
			$feedback = $('.feedback');
			if (result.success) {
				$feedback.addClass('alert-success');
			}
			else {
				$feedback.addClass('alert-danger');
			}
			$feedback.html(result.message).fadeIn();
			window.setTimeout(function() {
				window.location.replace('/');
			}, 2000);
		});
	}
});
