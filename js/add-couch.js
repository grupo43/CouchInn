/* INITIALIZE SEARCH INPUT */
var input = document.getElementById('input-city');
var options = {
	types: ['(cities)'],
	componentRestrictions: {
		country: 'ar'
	}
};
autocomplete = new google.maps.places.Autocomplete(input, options);

/* FORCE CITY SELECTION */
$('#input-city').blur(function() {
	window.setTimeout(function() {
		var place = autocomplete.getPlace();
		if (place) {
			$('#input-city').val(place.formatted_address);
		}
		else {
			$('#input-city').val('');
		}
	}, 1000);
});

/* PHOTOS PREVIEW AND VALIDATION */
$inputPhotos = $('#input-photos');
$inputPhotos.change(function() {
	images = [];
	$('#photos-preview').fadeOut();
	var files = $inputPhotos[0].files;
	if (files.length <= 5 && areImages(files)) {
		$('.feedback-error').fadeOut();
		$('#photos-preview').fadeOut(function() {
			$(this).children().html('');
			$.each($inputPhotos[0].files, function(index, file) {
				var reader = new FileReader();
				reader.onload = function(e) {
					if (index < 3) {
						$row = $('#ph-preview-add-r1');
					}
					else {
						$row = $('#ph-preview-add-r2');
						$row.show();
					}
					var div = '<div class="col-md-4"><img class="img-thumbnail" src="' + e.target.result + '"></div>';
					$row.append(div);
					images.push(e.target.result);
				};
				reader.readAsDataURL(file);
			});
			$('#photos-preview').fadeIn();
		});
	}
	/* ERROR */
	else {
		if (files.length > 5) {
			$('.feedback-error').text('Lo sentimos, no puede subir más de 5 imágenes.').fadeIn();
		}
		else {
			$('.feedback-error').text('Todos los archivos deben ser imágenes (jpeg/png)').fadeIn();
		}
		$inputPhotos.val('');
	}
});

/* ALIGN PHOTOS */
$('#ph-preview-add-r1, #ph-preview-add-r2').bind("DOMSubtreeModified", function() {
	var children = $(this).children();
	var offset = ((12 - children.length * 4) / 2);
	$(this).children().first().addClass('col-md-offset-' + offset);
});

/* FORM SUBMISSION */
var $form = $('#add-couch-form');
$form.submit(function($e) {
	$e.preventDefault();
	if (!$form.find('input[type=submit]').hasClass('disabled')) {
		$.post('/resources/library/add_couch.php', {
			formData: $form.serialize(),
			photos: images
		}, function(couchID) {
			window.location = 'couch.php?id=' + couchID;
		});
	}
});

/* MODAL GETS HIDDEN */
$('.modal').on('hidden.bs.modal', function() {
	autocomplete = new google.maps.places.Autocomplete(input, options); // Reset city value
	$('.feedback-error').hide(); // Hide feedback errors
	$('#photos-preview, #ph-preview-add-r2').hide(); // Hide photos
});

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$('#add-couch-form').validator('destroy').validator();
});
