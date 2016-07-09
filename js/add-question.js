$('#add-question').submit(function($e) {
	$e.preventDefault();
	$.post('/resources/library/add_question.php', $(this).serialize(), function(user) {
		var question = $('input[name="question"]').val();
		$('#questions').prepend(
			'<li><i class="fa fa-comment" aria-hidden="true"></i> <strong>' + user + ': </strong>' + question + '</li><br />'
		);
		$(this).trigger('reset');
	});
});
