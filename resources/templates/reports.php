<div class="col-md-6">
	<h2 class="sub-header text-center">Ventas premium</h2>
	<form id="report-premium-sales" action="/resources/library/premium_report.php" method="post">
	<div id="datepicker" class="input-daterange input-group" >
		<input type="text" class="input form-control" name="from" required />
		<span class="input-group-addon">hasta</span>
		<input type="text" class="input form-control" name="to" required />
	</div>
	<br />
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="col-md-6">
				<input class="btn btn-primary form-control" type="submit" value="Filtrar" />
			</div>
			<div class="col-md-6">
				<input id="reset-premium-report" class="btn btn-default form-control" value="Restablecer" />
			</div>
		</div>
	</div>
	</form>
	<br />
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Usuario</th>
					<th>Monto</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody id="premium-report-table">
			<?php
			$sales = getPremiumSales();
			foreach ($sales as $sale):
				$date = substr($sale['date'], 0, 10);
				$date = implode('/', array_reverse(explode('-', $date)));
				$time = substr($sale['date'], 10);
			?>
			<tr>
				<td><?php echo $sale['user'] ?></td>
				<td><?php echo $sale['amount'] ?></td>
				<td><?php echo $date.$time ?></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<div class="col-md-6">
	<h2 class="sub-header text-center">Reservas Concretadas</h2>
	<form action="javascript:void(0)" method="post">
		<div class="input-daterange input-group" >
			<input type="text" class="input form-control" name="from" required />
			<span class="input-group-addon">hasta</span>
			<input type="text" class="input form-control" name="to" required />
		</div>
		<br />
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<div class="col-md-6">
					<input class="btn btn-primary form-control" type="submit" value="Filtrar" />
				</div>
				<div class="col-md-6">
					<input class="btn btn-default form-control" value="Restablecer" />
				</div>
			</div>
		</div>
	</form>
	<br />
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Usuario</th>
					<th>Couch</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Lorem</td>
					<td>ipsum</td>
					<td>dolor</td>
				</tr>
				<tr>
					<td>amet</td>
					<td>consectetur</td>
					<td>adipiscing</td>
				</tr>
				<tr>
					<td>Integer</td>
					<td>nec</td>
					<td>odio</td>
				</tr>
				<tr>
					<td>libero</td>
					<td>Sed</td>
					<td>cursus</td>
				</tr>
				<tr>
					<td>dapibus</td>
					<td>diam</td>
					<td>Sed</td>
				</tr>
				<tr>
					<td>Nulla</td>
					<td>quis</td>
					<td>sem</td>
				</tr>
				<tr>
					<td>nibh</td>
					<td>elementum</td>
					<td>imperdiet</td>
				</tr>
				<tr>
					<td>sagittis</td>
					<td>ipsum</td>
					<td>Praesent</td>
				</tr>
				<tr>
					<td>Fusce</td>
					<td>nec</td>
					<td>tellus</td>
				</tr>
				<tr>
					<td>augue</td>
					<td>semper</td>
					<td>porta</td>
				</tr>
				<tr>
					<td>massa</td>
					<td>Vestibulum</td>
					<td>lacinia</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
