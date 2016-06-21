var $couchesList = $('#couches-list');
var $arrows = $('#arrows');

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
