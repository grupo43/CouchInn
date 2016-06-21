service = new google.maps.places.PlacesService(document.getElementById('location'));
service.getDetails({placeId: $('#location').attr('place-id')}, function(place) {
	$('#location').html('<strong>Ubicación</strong><br />'+place.formatted_address);
});
