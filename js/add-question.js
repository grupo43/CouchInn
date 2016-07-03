var $questionForm = $('#add-question');
$questionForm.submit(function($e) {
	$e.preventDefault();
	var $questionList = $('#questions');
	var couchID = $('input[name="couchID"]').val();
	$.post('/resources/library/add_question.php', $questionForm.serialize(), function() {
		$.get('/resources/library/get_questions.php', {couchID: couchID}, function(questions) {
			if (questions.length) {
				$questionList.html('<ul>');
				$.each(questions, function(index, question) {
					$questionList.append('<li>' + question.question + '</li>');
					if (question.answer.length) {
						$questionList.append('<ul><li>' + question.answer + '</li></ul>');
					}
				});
			}
		});
	});
});
