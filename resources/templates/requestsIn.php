<?php
$sql = "
	SELECT r.id, host_id, guest, num_guests, `from`, till
	FROM
		reservation r JOIN couch c
		ON r.host_id = c.id
	WHERE c.owner = '{$_SESSION['user']}'
	ORDER BY r.id DESC 
";
$reservations = $db->query($sql);
?>

<h1 class="page-header">Solicitudes Recibidas</h1>
<br />
<?php if ($reservations->num_rows): ?>
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
	<?php foreach ($reservations as $index => $reservation):
	$userScore = userScore($reservation['guest']);
	if ($userScore):
		$userScore = round(($userScore * 2)) / 2;
	endif;
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
			<input class="user-score" value="<?php echo $userScore ?>">
		</td>
		<td><?php echo $reservation['num_guests'] ?></td>
		<td><?php echo implode('/', array_reverse(explode('-', $reservation['from']))) ?><br />↓<br /><?php echo implode('/', array_reverse(explode('-', $reservation['till']))) ?></td>
		<td>
			<?php
			// TODO: Clean this mess!
			$sql = "SELECT id FROM accepted_reservation WHERE reservation_id = {$reservation['id']}";
			$accepted = $db->query($sql);
			if ($accepted->num_rows):
				if (date_create() > date_create($reservation['till'])):
					$sql = "
						SELECT *
						FROM guest_score
						WHERE reservation_id = {$reservation['id']}
					";
					$result = $db->query($sql);
					if ($result->num_rows):
						echo "Le diste al usuario un puntaje de ".$result->fetch_assoc()['score'];
					else: ?>
						<button id="vote" name="<?php echo $reservation['id'] ?>" class="btn btn-success" data-toggle="modal" data-target="#give-score-modal">Puntuar usuario</button>
					<?php
					endif;
				else:
					echo "La reserva fue aceptada";
				endif;
			else:
				$sql = "SELECT id FROM denied_reservation WHERE reservation_id = {$reservation['id']}";
				if ($db->query($sql)->num_rows):
					echo "La reserva fue rechazada";
					if ($_SESSION['user'] == getOwner($reservation['host_id'])):
						$sql = "
							SELECT *
							FROM (
								SELECT `from`, till
								FROM
									reservation r JOIN accepted_reservation ar
									ON r.id = ar.reservation_id
								WHERE `host_id` = '{$reservation['host_id']}'
							) AS accepted
							WHERE
								('{$reservation['from']}' BETWEEN accepted.from AND accepted.till) OR
								('{$reservation['till']}' BETWEEN accepted.from AND accepted.till) OR
								('{$reservation['from']}' < accepted.from AND '{$reservation['till']}' > accepted.till)
						";
						if ($db->query($sql)->num_rows):
							echo " automáticamente<br />(los días coinciden con otra reserva aceptada)";
						endif;
					endif;
				elseif (date_create() > date_create($reservation['from'])):
					echo "La reserva fue rechazada automáticamente<br />(la fecha de inicio de la misma ya pasó)";
				else: ?>
					<button class="btn btn-success accept-reservation" name="reservationID" value="<?php echo $reservation['id'] ?>">Aceptar</button>
					<button class="btn btn-danger deny-reservation" name="reservationID" value="<?php echo $reservation['id'] ?>">Rechazar</button>
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
