$('#datepicker').datepicker({
	startDate: "today",
	maxViewMode: 2,
	clearBtn: true,
	language: "es",
});

var $couchesList = $('#couches-list');
var $arrows = $('#arrows');

var sql = "SELECT * FROM couch WHERE enabled = 1 ORDER BY publication_date DESC";

$('#search-form').submit(function($e) {
	$e.preventDefault();
	sql = "SELECT * FROM couch WHERE enabled = 1 ORDER BY publication_date DESC";
	var filter= "";
	var capacity = $(this).find('input[name="inputCapacity"]').val();
	if (capacity.length) {
		filter += " AND capacity >= '" + capacity + "'"; // Append couch capacity filter
	}
	var type = $(this).find('select[name="couchType"]').val();
	if (type.length) {
		filter += " AND type = '" + type + "'"; // Append couch type filter
	}
	var input = $(this).find('input[name="search"]').val();
	if (input.length) {
		filter += " AND (title LIKE '%" + input + "%' OR description LIKE '%" + input + "%')"; // Append title/description filter
	}
	var from = $(this).find('input[name="from"]').val();
	var till = $(this).find('input[name="till"]').val();
	if (from.length && till.length) { // Append available dates filter
		from = moment(from, "DD/MM/YYYY").format("YYYY-MM-DD");
		till = moment(till, "DD/MM/YYYY").format("YYYY-MM-DD");
		filter += " AND id NOT IN (";
		filter += "SELECT couch_id FROM (";
		filter += "SELECT couch_id, `from`, till FROM reservation WHERE id IN (SELECT reservation_id FROM accepted_reservation)) AS accepted";
		filter += " WHERE (DATE('" + from + "') BETWEEN accepted.from AND accepted.till) OR (DATE('" + till + "')) BETWEEN accepted.from AND accepted.till)";
	}
	if (filter.length) {
		var insertPoint = sql.indexOf('1') + 1;
		sql = [sql.slice(0, insertPoint), filter, sql.slice(insertPoint)].join(''); // Append filters into SQL statement
	}
	$.getJSON('/resources/library/get_couches.php', {
		page: 1,
		sql: sql
	}, function(html) {
		$couchesList.fadeOut(200, function() {
			$(this).html(html.couches).fadeIn(200);
		});
		$arrows.html(html.arrows);
	});
});

$arrows.on("click", "a", function($e) {
	$e.preventDefault();
	var pageNumber = $(this).attr('name');
	$.getJSON('/resources/library/get_couches.php', {
		page: pageNumber,
		sql: sql
	}, function(html) {
		$couchesList.fadeOut(200, function() {
			$(this).html(html.couches).fadeIn(200);
		});
		$arrows.html(html.arrows);
	});
});
