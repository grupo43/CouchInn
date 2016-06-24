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

/* PHOTOS */
var imagesArr	= [];
var imagesCount = 0;

// Validate and add
$('#input-photos').change(function() {
	var files = $(this)[0].files;
	if (files.length + imagesCount <= 5 && areImages(files)) {
		$(this).closest('.form-group').removeClass('has-error');
		$('.feedback-error').fadeOut();
		$.each(files, function(index, file) {
			var reader = new FileReader();
			reader.onload = function(e) {
				imagesArr.push(e.target.result);
				imagesCount++;
				previewAddPhoto(imagesArr.length-1, e.target.result);
			};
			reader.readAsDataURL(file);
		});
	}
	// Error
	else {
		if (files.length + imagesCount > 5) {
			$('.feedback-error').text('Lo sentimos, no puede subir más de 5 imágenes.').fadeIn();
		}
		else {
			$('.feedback-error').text('Todos los archivos deben ser imágenes (jpeg/png)').fadeIn();
			$('#input-photos').closest('.form-group').addClass('has-error');
		}
	}
	$('#photos-preview').show();
});

// Add photo to preview
var previewAddPhoto = function(index, photo) {
	$row = $('#ph-preview-add-r1');
	$row.show();
	if ($row.children().length >= 3) {
		$row = $('#ph-preview-add-r2');
		$row.show();
	}
	var div	 = '<div class="col-md-4 img-wrap">'; // Div wrapper
	div		+= '<span class="close" index="' + index + '">&times;</span>'; // Close button
	div		+= '<img class="img-thumbnail" src="' + photo + '"></div>'; // Photo
	$row.append(div);
};

// Delete photo
$('#ph-preview-add-r1, #ph-preview-add-r2').on("click", ".close", function() {
	var index = $(this).attr('index');
	imagesArr[index] = null;
	imagesCount--;
	$('#photos-preview, #ph-preview-add-r2').hide();
	$(this).closest('div').remove();
	if (imagesCount > 0) {
		updatePreview(imagesArr);
	}
});

// Update preview after deletion
var updatePreview = function(imagesArr) {
	$('#ph-preview-add-r1').html('');
	$('#ph-preview-add-r2').html('');
	var div;
	var photoNum = 0;
	$row = $('#ph-preview-add-r1');
	$.each(imagesArr, function(index, photo) {
		if (photo !== null) {
			photoNum++;
			if (photoNum > 3) {
				$row = $('#ph-preview-add-r2');
				$row.show();
			}
			div		 = '<div class="col-md-4 img-wrap">'; // Div wrapper
			div		+= '<span class="close" index="' + index + '">&times;</span>'; // Close button
			div		+= '<img class="img-thumbnail" src="' + photo + '"></div>'; // Photo
			$row.append(div);
		}
	});
	$('#photos-preview').show();
};

/* FORM SUBMISSION */
var $form = $('#add-couch-form');
$form.submit(function($e) {
	$e.preventDefault();
	imagesArr = imagesArr.filter(function(n) {
		return n !== null;
	});
	if (imagesArr.length >= 1) {
		if (!$form.find('input[type=submit]').hasClass('disabled')) {
			$.post('/resources/library/add_couch.php', {
				formData: $form.serialize(),
				photos: imagesArr
			}, function(couchID) {
				window.location = 'couch.php?id=' + couchID;
			});
		}
	} else {
		$('.feedback-error').text('Debe subir al menos una imagen.').fadeIn();
		$('#input-photos').closest('.form-group').addClass('has-error');
	}
});

/* MODAL GETS HIDDEN */
$('.modal').on('hidden.bs.modal', function() {
	autocomplete = new google.maps.places.Autocomplete(input, options); // Reset city value
	$('.feedback-error').hide(); // Hide feedback errors
	$('#photos-preview, #ph-preview-add-r2').hide(); // Hide photos
	imagesArr = []; // Empty images array
});

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$('#add-couch-form').validator('destroy').validator();
});
