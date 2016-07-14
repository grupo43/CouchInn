$('#add-question').submit(function($e) {
	$form = $(this);
	$e.preventDefault();
	$.post('/resources/library/add_question.php', $form.serialize(), function(user) {
		var question = $('input[name="question"]').val();
		$('#questions').prepend(
			'<li><i class="fa fa-comment" aria-hidden="true"></i> <strong>' + user + ': </strong>' + question + '</li><br />'
		);
		$form.trigger('reset');
	});
});
