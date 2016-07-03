$('#add-question').submit(function($e) {
	$e.preventDefault();
	var $questionList = $('#questions');
	var couchID = $('input[name="couchID"]').val();
	$.post('/resources/library/add_question.php', $(this).serialize(), function() {
		$.get('/resources/library/get_questions.php', {couchID: couchID}, function(questions) {
			$questionList.html('');
			$.each(questions, function(index, question) {
				$questionList.append(
					'<li><i class="fa fa-comment" aria-hidden="true"></i> ' + question.question + '</li>'
				);
				if (question.answer.length) {
					$questionList.append(
						'<ul>' +
							'<li><i class="fa fa-comments" aria-hidden="true"></i> ' + question.answer + '</li>' +
						'</ul>'
					);
				}
				$questionList.append(
					'<br />'
				);
			});
		});
	});
});
