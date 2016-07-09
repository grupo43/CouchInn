$('.answer-question').submit(function($e) {
	$e.preventDefault();
	var $questionList = $('#questions');
	var couchID = $('input[name="couchID"]').val();
	$.post('/resources/library/answer_question.php', $(this).serialize(), function() {
		$.get('/resources/library/get_owner.php', {couchID: couchID}, function(owner) {
			$.get('/resources/library/get_questions.php', {couchID: couchID}, function (questions) {
				$questionList.html('');
				$.each(questions, function (index, question) {
					$questionList.append(
						'<li><i class="fa fa-comment" aria-hidden="true"></i> <strong>' + question.user + ': </strong>' + question.question + '</li>'
					);
					if (question.answer.length) {
						$questionList.append(
							'<ul>' +
							'<li><i class="fa fa-comments" aria-hidden="true"></i> <strong>' + owner + ': </strong>' + question.answer + '</li>' +
							'</ul>' +
							'<br />'
						);
					}
					else {
						$questionList.append(
							'<ul>' +
							'<li>' +
							'<form class="answer-question" action="/resources/library/answer_question.php" method="POST">' +
							'<div class="col-md-10">' +
							'<input name="answer" class="form-control" placeholder="Escriba su respuesta.." type="text">' +
							'</div>' +
							'<input name="questionID" value="' + question.id + '" type="hidden">' +
							'<input name="couchID" value="' + couchID + '" type="hidden">' +
							'<input class="btn btn-primary" value="Enviar" type="submit">' +
							'</form>' +
							'</li>' +
							'</ul>'
						);
					}
				});
			});
		});
	});
});
