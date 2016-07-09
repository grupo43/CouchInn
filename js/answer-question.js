$('.answer-question').submit(function($e) {
	var $answer = $(this);
	$e.preventDefault();
	$.post('/resources/library/answer_question.php', $(this).serialize(), function(user) {
		var answer = $('input[name="answer"]').val();
		$answer.replaceWith(
			'<li><i class="fa fa-comments" aria-hidden="true"></i> <strong>' + user + ': </strong>' + answer + '</li></br>'
		);
	});
});
