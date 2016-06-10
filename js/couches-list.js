var $couchesList = $('#couches-list');
var $arrows = $('#arrows');

if (!$couchesList.html().length) { // Show first result page
	$.getJSON('/resources/library/get_couches.php', {
		page: 1
	}, function(html) {
		$couchesList.html(html.couches);
		$arrows.html(html.arrows);
	});
}

$arrows.on("click", "a", function($e) {
	$e.preventDefault();
	var pageNumber = $(this).attr('name');
	$.getJSON('/resources/library/get_couches.php', {
		page: pageNumber
	}, function(html) {
		$couchesList.fadeOut(200, function() {
			$(this).html(html.couches).fadeIn(200);
		});
		$arrows.html(html.arrows);
	});
});
