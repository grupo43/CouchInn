var $feedback = $('.feedback');
$feedback.on("click", "#send-token", function($e) {
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
	email = $(this).find('input[name="input-email"]').val();
	$.ajax('/resources/library/validate_email.php?input-email='+email).done(function() {
		$feedback.fadeOut(function() {
			$(this).addClass('alert-danger').html("Lo sentimos, no existe ninguna cuenta asociada a la dirección de email ingresada.").fadeIn();
		});
	}).fail(function() {
		$feedback.removeClass('alert-danger').addClass('alert-info').html('Enviando email  <i class="fa fa-spinner fa-pulse"></i>').fadeIn();
		$.get('resources/library/send_token.php?input-email='+email, function(result) {
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
});
