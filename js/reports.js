$table = $('#premium-report-table');

var updateSalesTable = function(range) {
	$.get('/resources/library/premium_report.php', range, function(sales) {
		$table.html('');
		if (sales.length) {
			var totalAmount = 0;
			$.each(sales, function(index, sale) {
				var date = sale.date.substr(0, 10);
				date = date.split("-").reverse().join("/");
				var time = sale.date.substr(10);
				var amount = sale.amount;
				totalAmount += parseFloat(amount);
				if (amount.substr(-2) == "00") {
					amount = amount.slice(0, -3);
				}
				$table.append(
					'<tr>' +
					'<td>' + sale.user + '</td>' +
					'<td>' + '$' + amount + '</td>' +
					'<td>' + date + time + '</td>' +
					'</tr>'
				);
			});
			$table.append(
				'<tr>' +
					'<td><strong>Monto total recaudado:</strong></td>' +
					'<td><strong>' + '$' + totalAmount + '</strong></td>' +
					'<td></td>' +
				'</tr>'
			);

		}
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
