<?php
function connect ($host = 'localhost', $user = 'root', $pass = '', $db_name = 'couchinn') {
	$db = new mysqli($host,$user,$pass,$db_name);
	if ($db->connect_error)
		die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
	return $db;
}

function isPremium ($user) {
	$db = connect();
	$sql = "
		SELECT * FROM payment
		WHERE user = '$user'
	";
	return $db->query($sql)->num_rows;
}

function generateToken ($email) {
	$salt = '7KH6jrq4j8GK4tCXVSUwzhDAefYUCCrs';
	return md5($salt.$email);
}

function isValidToken ($email, $token) {
	$salt = '7KH6jrq4j8GK4tCXVSUwzhDAefYUCCrs';
	return md5($salt.$email) == $token;
}

function getPictures ($couchID) {
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

function isOwner ($user, $couchID) {
	$db = connect();
	$sql = "
		SELECT enabled
		FROM couch
		WHERE id = '$couchID' AND owner = '{$_SESSION['user']}'
	";
	return $db->query($sql)->num_rows;
}

function isCouchEnabled ($couchID) {
	$db = connect();
	$sql = "
		SELECT enabled
		FROM couch
		WHERE id = '$couchID'
	";
	return $db->query($sql)->fetch_assoc()['enabled'];
}

?>
