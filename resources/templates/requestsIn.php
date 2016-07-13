<?php

// TODO: User->reservations()
$sql = "
	SELECT r.id
	FROM
		reservation r JOIN couch c
		ON r.couch_id = c.id
	WHERE c.owner = '{$_SESSION['user']}'
	ORDER BY r.id DESC 
";
$reservationsIds = $db->query($sql);
?>

<h1 class="page-header">Solicitudes Recibidas</h1>
<br />
<?php
if ($reservationsIds->num_rows):
	$reservationDao = new DataAccessObject('reservation');
?>
<table class="table table-bordered text-center valign-table">
	<thead>
		<tr>
			<th>Couch</th>
			<th>Usuario</th>
			<th>Huéspedes</th>
			<th>Fecha</th>
			<th>Estado</th>
		</tr>
	</thead>
	<?php while ($reservationId = $reservationsIds->fetch_row()[0]):
	$reservation = Reservation::withId($reservationId);
	$guestScore = userScore($reservation->guest);
	if ($guestScore):
		$guestScore = round(($guestScore * 2)) / 2;
	endif;
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
		<td>
			<?= $reservation->guest ?>
			<input class="display-only-score" value="<?= $guestScore ?>">
		</td>
		<td><?= $reservation->num_guests ?></td>
		<td><?= $reservation->from->format('d/m/Y') ?><br />↓<br /><?= $reservation->till->format('d/m/Y') ?></td>
		<td>
			<?php
			if ($reservation->wasAccepted()):
				if ($reservation->hasEnded()):
					if ($guestScore = $reservation->guestScore()):
						echo "Puntuaste al usuario con"; ?>
						<input class="display-only-score" value="<?= $guestScore ?>">
					<?php else: ?>
						<button name="<?= $reservation->id ?>" class="vote btn btn-success" data-toggle="modal" data-target="#vote-guest-modal">Puntuar usuario</button>
					<?php
					endif;
				else:
					echo "La reserva fue aceptada.<br />Podrá dejar un puntaje cuando esta finalice.";
				endif;
			else:
				if (!$reservation->wasDenied() && $reservation->hasStarted()):
					$reservation->deny();
				endif;
				if ($reservation->wasDenied()):
					echo "La reserva fue rechazada";
				else: ?>
					<button class="btn btn-success accept-reservation" name="reservationID" value="<?= $reservation->id ?>">Aceptar</button>
					<button class="btn btn-danger deny-reservation" name="reservationID" value="<?= $reservation->id ?>">Rechazar</button>
				<?php endif; ?>
			<?php endif; ?>
		</td>
	</tr>
	<?php endwhile; ?>
<?php else: ?>
	<div class="col-md-6">
		<div class="alert alert-info text-center">Aún no has recibido ninguna solicitud de alojamiento.</a></div>
	</div>
<?php endif; ?>
</table>
