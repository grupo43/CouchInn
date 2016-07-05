$table = $('#premium-report-table');

var updateSalesTable = function(range) {
	$.get('/resources/library/premium_report.php', range, function(sales) {
		$table.html('');
		$.each(sales, function(index, sale) {
			var date = sale.date.substr(0, 10);
			date = date.split("-").reverse().join("/");
			var time = sale.date.substr(10);
			$table.append(
				'<tr>' +
					'<td>' + sale.user + '</td>' +
					'<td>' + sale.amount + '</td>' +
					'<td>' + date + time + '</td>' +
				'</tr>'
			);
		});
	});
};

$('#report-premium-sales').submit(function($e) {
	$e.preventDefault();
	updateSalesTable($(this).serialize());
});


$('#reset-premium-report').click(function() {
	updateSalesTable();
	$('#report-premium-sales').trigger('reset');
});
