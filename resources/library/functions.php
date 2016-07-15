<?php
function connect($host = 'localhost', $user = 'root', $pass = '', $db_name = 'couchinn') {
	$db = new mysqli($host,$user,$pass,$db_name);
	if ($db->connect_error)
		die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
	return $db;
}

function isPremium($user) {
	$db = connect();
	$sql = "
		SELECT * FROM sale
		WHERE user = '$user'
	";
	return $db->query($sql)->num_rows;
}

function generateToken($email) {
	$salt = '7KH6jrq4j8GK4tCXVSUwzhDAefYUCCrs';
	return md5($salt.$email);
}

function isValidToken($email, $token) {
	$salt = '7KH6jrq4j8GK4tCXVSUwzhDAefYUCCrs';
	return md5($salt.$email) == $token;
}

function userScore($user) {
	$db = connect();
	$sql = "
		SELECT AVG(score)
		FROM
			guest_score gs JOIN reservation r
			ON gs.reservation_id = r.id
		WHERE guest = '$user'
	";
	return $db->query($sql)->fetch_row()[0];
}

function getCouchesPaginator (
	$page,
	$sql = "SELECT * FROM couch WHERE enabled = 1 ORDER BY publication_date DESC")
{
	require_once 'paginator.php';

	$db = connect();

	$Paginator = new Paginator($db, $sql);
	$results = $Paginator->getData($page);

	$couches = $results->data;
	$couchesHtml = "";
	if (count($couches) > 0) {
		for ($i = 0; $i < count($couches); $i++):
			$couch = $couches[$i];
			if (isPremium($couch['owner'])):
				$sql = "
					SELECT picture1
					FROM couch_picture
					WHERE couch_id = {$couch['id']}
				";
				$img = $db->query($sql)->fetch_row()[0];
			else:
				$img = 'img/logo/couch.png';
			endif;
			$couchesHtml .= '<div class="couch col-lg-4">';
			$couchesHtml .= '<img class="img-circle" src="' . $img . '" alt="Couch image" width="140" height="140" />'; // Add picture
			$couchesHtml .= '<h3>' . substr($couch['title'], 0, 24) . '..</h3>'; // Couch title
			$couchesHtml .= '<p>' . substr($couch['description'], 0, 90) . '..</p>'; // Description
			$couchesHtml .= '<p><a class="btn btn-primary" href="couch?id=' . $couch['id'] . '" role="button">Ver detalles &raquo;</a></p>'; // Details button
			$couchesHtml .= '</div>';
		endfor;

		$arrowsHtml = $Paginator->getArrows();
	} else {
		$couchesHtml = '
			<div class="col-md-offset-2 col-md-8">
				<div class="alert alert-danger text-center" role="alert">Lo sentimos, ningún couch coincide con su búsqueda.</div>
			</div>';
		$arrowsHtml = "";
	}

	return ["couches" => $couchesHtml, "arrows" => $arrowsHtml];
}

function getCouchTypes() {
	$db = connect();

	$sql = "
		SELECT * FROM couch_type
		WHERE enabled = 1
		ORDER BY name
	";
	$result = $db->query($sql);
	$couch_types = array();
	while ($row = $result->fetch_assoc()):
		$couch_types[] = $row['name'];
	endwhile;
	return $couch_types;
}

function getPictures($couchID) {
	$db = connect();
	$sql = "
		SELECT picture1
			, picture2
			, picture3
			, picture4
			, picture5
		FROM couch_picture
		WHERE couch_id = '$couchID'
	";
	$result = $db->query($sql)->fetch_row();
	$pictures = array();
	foreach ($result as $picture):
		if ($picture): // If pictureX was loaded
			$pictures[] = $picture;
		endif;
	endforeach;
	return $pictures;
}

function getQuestions($couchID) {
	$db = connect();
	$sql = "
		SELECT id, `user`, couch_id, question, answer
		FROM `q&a`
		WHERE couch_id = '$couchID'
		ORDER BY `date` DESC
	";
	$result = $db->query($sql);
	$questions = array();
	while ($question = $result->fetch_assoc()):
		$questions[] = $question;
	endwhile;
	return $questions;
}

function getPremiumSales($from = "", $to = "") {
	$db = connect();
	$sql = "SELECT * FROM sale";
	if ($from && $to):
		$sql .= " WHERE `date` BETWEEN '$from' AND '$to'";
	endif;
	$sql .= " ORDER BY `date` DESC";
	$result = $db->query($sql);
	$sales = array();
	while ($sale = $result->fetch_assoc()):
		$sales[] = $sale;
	endwhile;
	return $sales;
}

function getTotalEarn() {
	$db = connect();
	$sql = "SELECT SUM(amount) FROM sale";
	return $db->query($sql)->fetch_row()[0];
}

function getOwner($couchID) {
	$db = connect();
	$sql = "
		SELECT owner
		FROM couch
		WHERE id = '$couchID'
	";
	return $db->query($sql)->fetch_row()[0];
}

function isOwner($user, $couchID) {
	$db = connect();
	$sql = "
		SELECT id
		FROM couch
		WHERE id = '$couchID' AND owner = '$user'
	";
	return $db->query($sql)->num_rows;
}

function isCouchEnabled($couchID) {
	$db = connect();
	$sql = "
		SELECT enabled
		FROM couch
		WHERE id = '$couchID'
	";
	return $db->query($sql)->fetch_assoc()['enabled'];
}

function emailReservationToHost($reservation, $host, $guest, $headers) {
	$from = $reservation->from->format('Y-m-d');
	$till = $reservation->till->format('Y-m-d');
	$guestScore = userScore($reservation->guest);
	if ($guestScore):
		$guestScore = round($guestScore, 2);
	else:
		$guestScore = '0 - nula';
	endif;
	$subject = "Couch Inn - Datos de reserva";
	$body = '
		<html>
		
		<head>
			<meta charset="utf-8">
		</head>
		
		<body>
			<p>Hola <strong>'.$host['name'].'</strong>,
				<br />te confirmamos que has aceptado la siguiente reserva.
			</p>
			<fieldset style="display: inline-block">
				<legend><strong>Reserva</strong></legend>
				<p>Couch: <a href="http://couchinn.com/couch?id='.$reservation->couch_id.'">Ver Couch</a></p>
				<p>Huésped: <em>'.$reservation->guest.'</em> (reputación: '.$guestScore.')</p>
				<p>Cant. de huéspedes: '.$reservation->num_guests.'</p>
				<p>Fecha: '.$from.' → '.$till.'</p>
			</fieldset>
			<fieldset style="display: inline-block">
				<legend><strong>Datos del huésped</strong></legend>
				<p>Nombre: '.$guest['name'].'</p>
				<p>Teléfono: '.$guest['phone_number'].'</p>
				<p>Email: <a href="mailto:'.$guest['email'].'">'.$guest['email'].'</a></p>
			</fieldset>
			</p>
			<p>Saludos,
				<br />
				<em>Couch Inn</em>.
			</p>
		</body>
		
		</html>
	';
	mail($host['email'], $subject, $body, $headers);
}

function emailReservationToGuest($reservation, $host, $guest, $headers) {
	$from = $reservation->from->format('Y-m-d');
	$till = $reservation->till->format('Y-m-d');
	$subject = "Couch Inn - Reserva aceptada";
	$body = '
		<html>
		
		<head>
			<meta charset="utf-8">
		</head>
		
		<body>
			<p>Hola <strong>'.$guest['name'].'</strong>,
				<br />te informamos que la siguiente reserva fue aceptada.
			</p>
			<fieldset style="display: inline-block">
				<legend><strong>Reserva</strong></legend>
				<p>Couch: <a href="http://couchinn.com/couch?id='.$reservation->couch_id.'">Ver Couch</a></p>
				<p>Cant. de huéspedes: '.$reservation->num_guests.'</p>
				<p>Fecha: '.$from.' → '.$till.'</p>
			</fieldset>
			<fieldset style="display: inline-block">
				<legend><strong>Datos del anfitrión</strong></legend>
				<p>Nombre: '.$host['name'].'</p>
				<p>Teléfono: '.$host['phone_number'].'</p>
				<p>Email: <a href="mailto:'.$host['email'].'">'.$host['email'].'</a></p>
			</fieldset>
			</p>
			<p>Saludos,
				<br />
				<em>Couch Inn</em>.
			</p>
		</body>
		
		</html>
	';
	mail($guest['email'], $subject, $body, $headers);
}

function emailReservation($reservation) {
	$db = connect();
	$sql = "
		SELECT username, email, name, birthdate, phone_number
		FROM user
		WHERE username = '{$reservation->guest}'
	";
	$guest = $db->query($sql)->fetch_assoc();
	$sql = "
		SELECT username, email, name, birthdate, phone_number
		FROM couch c
			JOIN user u
				ON c.owner = u.username
		WHERE
			c.id = $reservation->couch_id
		
	";
	$host = $db->query($sql)->fetch_assoc();
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: "Couch Inn" <couchinn@couch.com>';
	emailReservationToHost($reservation, $host, $guest, $headers);
	emailReservationToGuest($reservation, $host, $guest, $headers);
}
