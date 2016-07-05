$table = $('#premium-report-table');

var updateSalesTable = function(range) {
	$.get('/resources/library/premium_report.php', range, function(sales) {
		if (sales.length) {
			var rows = "";
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
				rows +=
					'<tr>' +
						'<td>' + sale.user + '</td>' +
						'<td>' + '$' + amount + '</td>' +
						'<td>' + date + time + '</td>' +
					'</tr>';
			});
			$table.fadeOut(function() {
				$(this).html(
					'<table class="table table-striped">' +
						'<thead>' +
							'<tr>' +
								'<th>Usuario</th>' +
								'<th>Monto</th>' +
								'<th>Fecha</th>' +
							'</tr>' +
						'</thead>' +
						'<tbody>' +
							rows +
							'<tr>' +
								'<td><strong>Monto total recaudado:</strong></td>' +
								'<td><strong>' + '$' + totalAmount + '</strong></td>' +
								'<td></td>' +
							'</tr>' +
						'</tbody>' +
					'</table>'
				).slideDown();
			});
		}
		else {
			$table.fadeOut(function() {
				$(this).html('<div class="alert alert-info text-center" role="alert">No hay ventas en ese rango de fechas.</div>');
			}).fadeIn();
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
