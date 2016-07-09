<?php
$sql = "
	SELECT *
	FROM reservation
	WHERE host_id IN (
		SELECT id
		FROM couch
		WHERE owner = '{$_SESSION['user']}'
	)
	ORDER BY id DESC 
";
$reservations = $db->query($sql);
?>

<h1 class="page-header">Solicitudes Recibidas</h1>
<br />
<?php if ($reservations->num_rows): ?>
<table class="table table-bordered text-center valign-table">
	<thead class="h3">
		<tr>
			<td>Couch</td>
			<td>Usuario</td>
			<td>Huéspedes</td>
			<td>Fecha</td>
			<td>Estado</td>
		</tr>
	</thead>
	<?php foreach ($reservations as $index => $reservation):
	$sql = "
		SELECT picture1
		FROM couch_picture
		WHERE couch_id = {$reservation['host_id']}
	";
	$img = $db->query($sql)->fetch_row()[0]; ?>
	<tr>
		<td>
			<a href="/couch?id=<?php echo $reservation['host_id'] ?>"><img class="couch thumbnail center-block" src="<?php echo $img ?>" alt="Couch image" width="128" height="128" /></a>
		</td>
		<td>
			<?php echo $reservation['guest'] ?>
			<input id="user-score" value="2">
		</td>
		<td><?php echo $reservation['num_guests'] ?></td>
		<td><?php echo implode('/', array_reverse(explode('-', $reservation['from']))) ?><br />↓<br /><?php echo implode('/', array_reverse(explode('-', $reservation['till']))) ?></td>
		<td>
			<?php
			$sql = "SELECT id FROM accepted_reservation WHERE reservation_id = {$reservation['id']}";
			if ($db->query($sql)->num_rows):
				echo "La reserva fue aceptada";
			else:
				$sql = "SELECT id FROM denied_reservation WHERE reservation_id = {$reservation['id']}";
				if ($db->query($sql)->num_rows):
					echo "La reserva fue rechazada";
				elseif (date_create() > date_create($reservation['from'])):
					echo "La reserva fue rechazada automáticamente<br />(la fecha de inicio de la misma ya pasó)";
				else: ?>
					<button class="btn btn-success">Aceptar</button>
					<button class="btn btn-danger">Rechazar</button>
				<?php endif;
			endif;
			?>
		</td>
	</tr>
	<?php endforeach; ?>
<?php else: ?>
	<div class="col-md-6">
		<div class="alert alert-info text-center">Aún no has recibido ninguna solicitud de alojamiento.</a></div>
	</div>
<?php endif; ?>
</table>
