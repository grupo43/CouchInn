var $feedback = $('.feedback');

$('#toggle-couch').click(function($e) {
	$e.preventDefault();
	var $anchor = $(this);
	var href = $anchor.attr('href');
	$.get(href, function(result) {
		$feedback.fadeOut(function() {
			$feedback.removeClass('alert-danger').addClass('alert-info');
			if (result.disabled) {
				$anchor.removeClass('btn-warning').addClass('btn-success').text('Habilitar');
				$feedback.html("El couch ha sido <strong>deshabilitado</strong>");
			}
			else {
				$anchor.removeClass('btn-success').addClass('btn-warning').text('Deshabilitar');
				$feedback.html("El couch ha sido <strong>habilitado</strong>");
			}
			$feedback.fadeIn();
		});
	});
});

$('#delete-couch').click(function($e) {
	$e.preventDefault();
	if (confirm('¿Estás seguro?')) {
		var $anchor = $(this);
		var href = $anchor.attr('href');
		$.get(href, function(result) {
			if (result.disabled) {
				$feedback.fadeOut(function() {
					var $toggleButton = $('#toggle-couch');
					$feedback.text("");
					if ($toggleButton.hasClass('btn-warning')) {
						$toggleButton.removeClass('btn-warning').addClass('btn-success').text('Habilitar');
						$feedback.html("El couch ha sido <strong>deshabilitado</strong> debido a que hay reservas pendientes.<br />");
					}
					else {
						$feedback.removeClass('alert-info').addClass('alert-danger');
					}
					$feedback.html($feedback.html() + "Si desea eliminar el couch, rechaze las reservas pendientes y vuelva a intentarlo.").fadeIn();
				});
			}
			else {
				window.location.replace('/');
			}
		});
	}
});
