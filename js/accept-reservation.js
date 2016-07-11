$('.accept-reservation').click(function() {
	$(this).parent('td').html('<span class="alert alert-info">Enviando email  <i class="fa fa-spinner fa-pulse"></i></span>');
	$.post('resources/library/accept_reservation.php', {reservationID: $(this).val()}, function() {
		window.location.reload();
	});
});
