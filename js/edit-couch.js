/* INITIALIZE SEARCH INPUT */
var input = document.getElementById('input-city-edit');
var options = {
	types: ['(cities)'],
	componentRestrictions: {
		country: 'ar'
	}
};
autocompleteEdit = new google.maps.places.Autocomplete(input, options);

/* FORCE CITY SELECTION */
$('#input-city-edit').blur(function() {
	window.setTimeout(function() {
		var placeEdit = autocompleteEdit.getPlace();
		if (placeEdit) {
			$('#input-city-edit').val(placeEdit.formatted_address);
		}
		else {
			$('#input-city-edit').val('');
		}
	}, 1000);
});

/* PHOTOS */
var imagesArrEdit	= [];
var imagesCountEdit = 0;

// Get couch photos
$.getJSON('/resources/library/get_couch_pictures.php', location.search.substr(1), function(pictures) {
	imagesArrEdit = pictures;
	imagesCountEdit = imagesArrEdit.length;
	updatePreviewEdit(imagesArrEdit);
});

var updatePreviewEdit = function(photos) {
	$('#ph-preview-edit-r1').html('');
	$('#ph-preview-edit-r2').html('');
	var div;
	var photoNum = 0;
	$row = $('#ph-preview-edit-r1');
	$.each(photos, function(index, photo) {
		if (photo !== null) {
			photoNum++;
			if (photoNum > 3) {
				$row = $('#ph-preview-edit-r2');
				$row.show();
			}
			div		 = '<div class="col-md-4 img-wrap">'; // Div wrapper
			div		+= '<span class="close" index="' + index + '">&times;</span>'; // Close button
			div		+= '<img class="img-thumbnail" src="' + photo + '"></div>'; // Photo
			$row.append(div);
		}
	});
	$('#photos-preview-edit').show();
};

// Validate and add
$('#input-photos-edit').change(function() {
	var files = $(this)[0].files;
	if (files.length + imagesCountEdit <= 5 && areImages(files)) {
		$(this).closest('.form-group').removeClass('has-error');
		$('.feedback-error').fadeOut();
		$.each(files, function(index, file) {
			var reader = new FileReader();
			reader.onload = function(e) {
				imagesArrEdit.push(e.target.result);
				imagesCountEdit++;
				previewPhotoEdit(imagesArrEdit.length-1, e.target.result);
			};
			reader.readAsDataURL(file);
		});
	}
	// Error
	else {
		$('#input-photos-edit').closest('.form-group').addClass('has-error');
		if (files.length + imagesCountEdit > 5) {
			$('.feedback-error').text('Lo sentimos, no puede subir más de 5 imágenes.').fadeIn();
		}
		else {
			$('.feedback-error').text('Todos los archivos deben ser imágenes (jpeg/png)').fadeIn();
		}
	}
	$('#photos-preview-edit').show();
});

// Add photo to preview
var previewPhotoEdit = function(index, photo) {
	$row = $('#ph-preview-edit-r1');
	$row.show();
	if ($row.children().length >= 3) {
		$row = $('#ph-preview-edit-r2');
		$row.show();
	}
	var div	 = '<div class="col-md-4 img-wrap">'; // Div wrapper
	div		+= '<span class="close" index="' + index + '">&times;</span>'; // Close button
	div		+= '<img class="img-thumbnail" src="' + photo + '"></div>'; // Photo
	$row.append(div);
};

// Delete photo
$('#ph-preview-edit-r1, #ph-preview-edit-r2').on("click", ".close", function() {
	var indexEdit = $(this).attr('index');
	imagesArrEdit[indexEdit] = null;
	imagesCountEdit--;
	$('#photos-preview-edit, #ph-preview-edit-r2').hide();
	$(this).closest('div').remove();
	if (imagesCountEdit > 0) {
		updatePreviewEdit(imagesArrEdit);
	}
	else {
		$('#input-photos-edit').closest('.form-group').removeClass('has-error');
		$('.feedback-error').fadeOut();
	}
});

// Form submission
var $editForm = $('#edit-couch-form');
$editForm.submit(function($e) {
	$e.preventDefault();
	imagesArrEdit = imagesArrEdit.filter(function(n) {
		return n !== null;
	});
	if (imagesArrEdit.length >= 1) {
		if (!$editForm.find('input[type=submit]').hasClass('disabled')) {
			if (!autocompleteEdit.getPlace()) {
				$('#input-city-edit').val('');
			}
			var data = $editForm.find(":input").filter(function() {
				return $.trim(this.value).length > 0;
			}).serialize();
			data += '&' + location.search.substr(1);
			$.post('/resources/library/edit_couch.php', {
				formData: data,
				photos: imagesArrEdit
			}, function() {
				window.location.reload();
			});
		}
	} else {
		$('.feedback-error').text('Debe subir al menos una imagen.').fadeIn();
		$('#input-photos-edit').closest('.form-group').addClass('has-error');
	}
});

/* MODAL GETS HIDDEN */
$('#edit-couch-modal').on('hidden.bs.modal', function() {
	autocompleteEdit = new google.maps.places.Autocomplete(cityInput, options); // Reset city value
	$('.feedback-error').hide(); // Hide feedback errors
	$('#photos-preview-edit, #ph-preview-edit-r2').hide(); // Hide photos
	// Reset images array
	$.getJSON('/resources/library/get_couch_pictures.php', location.search.substr(1), function(pictures) {
		imagesArrEdit = pictures;
		imagesCountEdit = imagesArrEdit.length;
		updatePreviewEdit(imagesArrEdit);
	});
	$(this).find('select').css('color', 'gray');
});

/* BLACK OPTIONS WHEN SELECT IS FOCUSED */
$('select').focus(function() {
	$(this).css('color', 'black');
});

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$('#edit-couch-form').validator('destroy').validator();
});

