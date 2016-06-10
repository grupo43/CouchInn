var $feedback = $('.feedback');
$feedback.on("click", "#reset-password", function($e) {
	$e.preventDefault();
	$feedback.fadeOut(function() {
		$(this).removeClass('alert-danger').addClass('alert-info').html('Enviando email  <i class="fa fa-spinner fa-pulse"></i>').fadeTo(400, 1);
	});
	var sendToken = $(this).attr('href');
	$.get(sendToken, function(result) {
		$feedback.fadeOut(function() {
			$(this).removeClass('alert-info');
			if (result.success) {
				$(this).addClass('alert-success');
			}
			else {
				$(this).addClass('alert-danger');
			}
			$(this).html(result.message).fadeIn();
		});
	});
});

$('#send-token-form').submit(function($e) {
	$e.preventDefault();
	$feedback.fadeOut(function() {
		$(this).removeClass('alert-danger').addClass('alert-info').html('Enviando email  <i class="fa fa-spinner fa-pulse"></i>').fadeTo(400, 1);
	});
	var formData = $(this).serialize();
	$.get('/resources/library/send_token.php', formData, function(result) {
		console.log(result);
		$feedback.fadeOut(function() {
			$(this).removeClass('alert-info');
			if (result.success) {
				$(this).addClass('alert-success');
			}
			else {
				$(this).addClass('alert-danger');
			}
			$(this).html(result.message).fadeIn();
		});
	});
});

/* HIDE LOGIN MODAL */
$('#login-modal').on("click", "a", function() {
	$('#login-modal').modal('hide');
});
