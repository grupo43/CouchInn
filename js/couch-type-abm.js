var $form = $('#couch-type-abm-form');
var $selectedCouchType = $('select[name="couch-type-name"]');
var $feedback = $('.feedback');

var getCouchTypes = function() {
	$.getJSON('/resources/library/get_couch_types.php', function(result) {
		$selectedCouchType.html('<option value="">-</option>');
		$.each(result, function(index, value) {
			var option = '<option value="' + value + '">' + value + '</option>';
			$selectedCouchType.append(option);
		});
	});
};

var resetInput = function() {
	$('input[name="new-value"]').val('');
	$('input[name="delete"]').prop('disabled', true);
	$('input[name="edit"]').val('Agregar').prop('disabled', true);
}

var abm = function(mode) {
	var formData = $form.serialize();
	formData += mode;
	$.post('/resources/library/couch_type_abm.php', formData, function(result) {
		$feedback.fadeOut(function() {
			if (result.success) {
				$(this).removeClass('alert-danger').addClass('alert-success');
			}
			else {
				$(this).removeClass('alert-success').addClass('alert-danger');
			}
			$(this).html(result.message).fadeIn();
		});
		getCouchTypes();
	});
	resetInput();
};

/* EDIT (add/modify) */
$('input[name="edit"]').click(function($e) {
	$e.preventDefault();
	var $newValueInput = $('input[name="new-value"]');
	var trimmedValue = $.trim($newValueInput.val());
	$newValueInput.val(trimmedValue);
	if (trimmedValue == $selectedCouchType.val()) {
		$feedback.fadeOut(function() {
			$(this).removeClass('alert-success').addClass('alert-danger').html('Debe introducir un valor<br />distinto al seleccionado').fadeIn();
		});
	}
	else {
		abm('&edit');
	}
});

/* DELETE */
$('input[name="delete"]').click(function($e) {
	$e.preventDefault();
	if (confirm("¿Estás seguro?")) {
		abm('&delete');
	}
});

/* TYPE VALUE SELECTION */
$selectedCouchType.click(function() {
	if ($(this).val()) {
		$('input[name="new-value"]').val($(this).val());
		$('input[name="delete"]').prop('disabled', false);
		$('input[name="edit"]').val('Modificar').prop('disabled', false);
	}
	else {
		resetInput();
	}
});

$('input[name="new-value"]').keyup(function() {
	$('input[name="edit"]').prop('disabled', isBlank($(this).val())); // Enable edit button only if new-value isn't empty
});
