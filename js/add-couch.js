/* INITIALIZE SEARCH INPUT */
var input = document.getElementById('input-city');
var options = {
	types: ['(cities)'],
	componentRestrictions: {
		country: 'ar'
	}
}
autocomplete = new google.maps.places.Autocomplete(input, options);

/* FORCE CITY SELECTION */
$('#input-city').blur(function() {
	window.setTimeout(function() {
		var place = autocomplete.getPlace();
		if (place) {
			$('#input-city').val(place.formatted_address)
		}
		else {
			$('#input-city').val('');
		}
	}, 1000)
})

var $form = $('#add-couch-form');
$form.submit(function($e) {
	$e.preventDefault();
	if (!$form.find('input[type=submit]').hasClass('disabled')) {
		$.ajax({
			url: '/resources/library/add_couch.php',
			type: 'POST',
			data: new FormData(this),
			processData: false,
			contentType: false
		}).done(function(result) {
			if (result.success) {
				window.location = 'couch.php?id='+result.id;
			}
			else {
				$('.feedback-error').fadeOut(function() {
					$(this).html(result.message).fadeIn();
				});
			}
		});
	}
})

/* MODAL GETS HIDDEN */
$('.modal').on('hidden.bs.modal', function() {
	autocomplete = new google.maps.places.Autocomplete(input, options); // Reset city value
	$('.feedback-error').hide(); // Hide feedback errors
});

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$('#add-couch-form').validator('destroy').validator();
});
