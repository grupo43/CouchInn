<?php
$sql = "
	SELECT id
	FROM reservation
	WHERE guest = '{$_SESSION['user']}'
	ORDER BY id DESC
";
$reservationsIds = $db->query($sql);
?>

<h1 class="page-header">Solicitudes Realizadas</h1>
<br />
<?php if ($reservationsIds->num_rows): ?>
<table class="table table-bordered text-center valign-table">
	<thead>
		<tr>
			<th>Couch</th>
			<th>Huéspedes</th>
			<th>Fecha</th>
			<th>Estado</th>
		</tr>
	</thead>
	<?php while ($reservationId = $reservationsIds->fetch_row()[0]):
	$reservation = Reservation::withId($reservationId);
	$sql = "
		SELECT picture1
		FROM couch_picture
		WHERE couch_id = {$reservation->couch_id}
	";
	$img = $db->query($sql)->fetch_row()[0]; ?>
	<tr>
		<td>
			<a href="/couch?id=<?= $reservation->couch_id ?>"><img class="couch thumbnail center-block" src="<?= $img ?>" alt="Couch image" width="128" height="128" /></a>
		</td>
		<td><?= $reservation->num_guests ?></td>
		<td><?= $reservation->from->format('d/m/Y') ?><br />↓<br /><?= $reservation->till->format('d/m/Y') ?></td>
		<td>
			<?php
			if ($reservation->wasAccepted()):
				if ($reservation->hasEnded()):
					if ($couchScore = $reservation->couchScore()):
						echo "Puntuaste al couch con"; ?>
						<input class="display-only-score" value="<?= $couchScore ?>">
					<?php else: ?>
						<button name="<?= $reservation->id ?>" class="vote btn btn-success" data-toggle="modal" data-target="#vote-couch-modal">Puntuar couch</button>
						<?php
					endif;
				else:
					echo "La reserva fue aceptada.<br />Podrá dejar un puntaje cuando esta finalice.";
				endif;
			else:
				if (!$reservation->wasDenied() && !$reservation->stillPending()):
					$reservation->deny();
				endif;
				if ($reservation->wasDenied()):
					echo "La reserva fue rechazada";
				else:
					echo "La reserva aún no ha sido aceptada/rechazada";
				endif;
			endif; ?>
		</td>
	</tr>
	<?php endwhile; ?>
<?php else: ?>
	<div class="col-md-6">
		<div class="alert alert-info text-center">Aún no has realizado ninguna solicitud de alojamiento.</a></div>
	</div>
<?php endif; ?>
</table>
