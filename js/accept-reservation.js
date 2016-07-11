var $denyButton = $('.deny-reservation');
$denyButton.click(function() {
	$.post('resources/library/deny_reservation.php', {reservationID: $(this).val()}, function() {
		$denyButton.parents('td').text('La reserva fue rechazada');
	});
});
