/* RESET FORM WHEN MODAL GETS HIDDEN */
$('.modal').on('hidden.bs.modal', function() {
	$(this).find('form').trigger('reset');
});
