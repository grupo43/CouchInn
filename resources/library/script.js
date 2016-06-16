/* RESET FORM WHEN MODAL GETS HIDDEN */
$('.modal').on('hidden.bs.modal', function() {
	$('form').trigger('reset');
});
