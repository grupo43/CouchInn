/* INITIALIZE SEARCH INPUT */
var cityInput = document.getElementById('input-city-add');
var options = {
	types: ['(cities)'],
	componentRestrictions: {
		country: 'ar'
	}
};
autocompleteAdd = new google.maps.places.Autocomplete(cityInput, options);

/* FORCE CITY SELECTION */
$('#input-city-add').blur(function() {
	window.setTimeout(function() {
		var placeAdd = autocompleteAdd.getPlace();
		if (placeAdd) {
			$('#input-city-add').val(placeAdd.formatted_address);
		}
		else {
			$('#input-city-add').val('');
		}
	}, 1000);
});

/* PHOTOS */
var imagesArrAdd	= [];
var imagesCountAdd	= 0;

// Validate and add
$('#input-photos-add').change(function() {
	var files = $(this)[0].files;
	if (files.length + imagesCountAdd <= 5 && areImages(files)) {
		$(this).closest('.form-group').removeClass('has-error');
		$('.feedback-error').fadeOut();
		$.each(files, function(index, file) {
			var reader = new FileReader();
			reader.onload = function(e) {
				imagesArrAdd.push(e.target.result);
				imagesCountAdd++;
				previewPhotoAdd(imagesArrAdd.length-1, e.target.result);
			};
			reader.readAsDataURL(file);
		});
	}
	// Error
	else {
		$('#input-photos-add').closest('.form-group').addClass('has-error');
		if (files.length + imagesCountAdd > 5) {
			$('.feedback-error').text('Lo sentimos, no puede subir más de 5 imágenes.').fadeIn();
		}
		else {
			$('.feedback-error').text('Todos los archivos deben ser imágenes (jpeg/png)').fadeIn();
		}
	}
	$('#photos-preview-add').show();
});

// Add photo to preview
var previewPhotoAdd = function(index, photo) {
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
	var indexAdd = $(this).attr('index');
	imagesArrAdd[indexAdd] = null;
	imagesCountAdd--;
	$('#photos-preview-add, #ph-preview-add-r2').hide();
	$(this).closest('div').remove();
	if (imagesCountAdd > 0) {
		updatePreviewAdd(imagesArrAdd);
	} else {
		$('#input-photos-add').closest('.form-group').removeClass('has-error');
		$('.feedback-error').fadeOut();
	}
});

// Update preview after deletion
var updatePreviewAdd = function(photos) {
	$('#ph-preview-add-r1').html('');
	$('#ph-preview-add-r2').html('');
	var div;
	var photoNum = 0;
	$row = $('#ph-preview-add-r1');
	$.each(photos, function(index, photo) {
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
	$('#photos-preview-add').show();
};

// Form submission
var $addForm = $('#add-couch-form');
$addForm.submit(function($e) {
	$e.preventDefault();
	imagesArrAdd = imagesArrAdd.filter(function(n) {
		return n !== null;
	});
	if (imagesArrAdd.length >= 1 && autocompleteAdd.getPlace()) {
		if (!$addForm.find('input[type=submit]').hasClass('disabled')) {
			$('#input-city-add').val(autocompleteAdd.getPlace().formatted_address);
			$.post('/resources/library/add_couch.php', {
				formData: $addForm.serialize(),
				photos: imagesArrAdd
			}, function(couchID) {
				window.location = 'couch.php?id=' + couchID;
			});
		}
	} else {
		if (imagesArrAdd.length < 1) {
			$('.feedback-error').text('Debe subir al menos una imagen.').fadeIn();
			$('#input-photos-add').closest('.form-group').addClass('has-error');
		}
		if (!autocompleteAdd.getPlace()) {
				$('#input-city-add').val('').closest('.form-group').addClass('has-error');
		}
	}
});

/* MODAL GETS HIDDEN */
$('#add-couch-modal').on('hidden.bs.modal', function() {
	autocompleteAdd = new google.maps.places.Autocomplete(cityInput, options); // Reset city value
	$('.feedback-error').hide(); // Hide feedback errors
	$('#photos-preview-add, #ph-preview-add-r2').hide(); // Hide photos
	imagesArrAdd	= []; // Empty images array
	imagesCountAdd	= 0; // Reset counter
});

/* VALIDATOR MODAL WORKAROUND */
$('.modal').on('shown.bs.modal', function() {
	$('#add-couch-form').validator('destroy').validator();
});
