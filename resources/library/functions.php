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
		SELECT * FROM payment
		WHERE user = '$user'
	";
	return $db->query($sql)->num_rows;
}

function delTree($dir) {
	$files = array_diff(scandir($dir), array('.','..'));
	foreach ($files as $file) {
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
	}
	return rmdir($dir);
}

function generateToken($email) {
	$salt = '7KH6jrq4j8GK4tCXVSUwzhDAefYUCCrs';
	return md5($salt.$email);
}

function isValidToken($email, $token) {
	$salt = '7KH6jrq4j8GK4tCXVSUwzhDAefYUCCrs';
	return md5($salt.$email) == $token;
}

function getCouchesPaginator($page) {
	require_once 'paginator.php';

	$db = connect();
	$sql = "
		SELECT *
		FROM couch
		WHERE enabled = 1
		ORDER BY publication_date DESC
	";

	$Paginator = new Paginator($db, $sql);
	$results = $Paginator->getData($page);

	$couches = $results->data;
	$couchesHtml = "";
	for ($i = 0; $i < count($couches); $i++):
		$couch = $couches[$i];
		if (isPremium($couch['owner'])):
			$sql = "
				SELECT picture1
				FROM couch_picture
				WHERE couch_id = {$couch['id']}
			";
			$mainPicture = $db->query($sql)->fetch_row()[0];
			$img = "img/couches/couch{$couch['id']}/".$mainPicture;
		else:
			$img = 'img/logo/couch.png';
		endif;
		$couchesHtml .= '<div class="couch col-lg-4">';
		$couchesHtml .= '<img class="img-circle" src="' . $img . '" alt="Couch image" width="140" height="140" />'; // Add picture
		$couchesHtml .= '<h3>' . substr($couch['title'], 0, 24) . '..</h3>'; // Couch title
		$couchesHtml .= '<p>' . substr($couch['description'], 0, 90) . '..</p>'; // Description
		$couchesHtml .= '<p><a class="btn btn-primary" href="couch.php?id=' . $couch['id'] . '" role="button">Ver detalles &raquo;</a></p>'; // Details button
		$couchesHtml .= '</div>';
	endfor;

	$arrowsHtml = $Paginator->getArrows();

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
		SELECT question, answer
		FROM `q&a`
		WHERE couch_id = '$couchID'
	";
	$result = $db->query($sql);
	$questions = array();
	while ($question = $result->fetch_assoc()):
		$questions[] = $question;
	endwhile;
	return $questions;
}

function isOwner($user, $couchID) {
	$db = connect();
	$sql = "
		SELECT enabled
		FROM couch
		WHERE id = '$couchID' AND owner = '{$_SESSION['user']}'
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

?>
