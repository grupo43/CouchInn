<?php
	$numRegisteredUsers = $db->query("SELECT username FROM user")->num_rows;
	$payments = $db->query("SELECT user, SUM(amount) total FROM sale");
	$numPayments = $payments->num_rows;
	$totalEarns = $payments->fetch_assoc()['total'];
?>
<h1 class="page-header">Panel de control</h1>
<div class="placeholders">
	<div class="col-md-3 placeholder">
		<img src="https://placeholdit.imgix.net/~text?txtsize=64&txt=<?= $numRegisteredUsers ?>&w=200&h=200" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
		<h4 class="text-muted">Usuarios Registrados</h4>
	</div>
	<div class="col-md-3 placeholder">
		<img src="https://placeholdit.imgix.net/~text?txtsize=64&txt=2&w=200&h=200" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
		<h4 class="text-muted">Usuarios Online</h4>
	</div>
	<div class="col-md-3 placeholder">
		<img src="https://placeholdit.imgix.net/~text?txtsize=64&txt=<?= $numPayments ?>&w=200&h=200" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
		<h4 class="text-muted">Usuarios Premium</h4>
	</div>
	<div class="col-md-3 placeholder">
		<img src="https://placeholdit.imgix.net/~text?txtsize=64&txt=$<?= round($totalEarns, 2) ?>&w=200&h=200" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
		<h4 class="text-muted">Ganancia</h4>
	</div>
</div>
