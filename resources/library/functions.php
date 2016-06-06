<?php
function connect ($host = 'localhost', $user = 'root', $pass = '', $db_name = 'couchinn') {
    $db = new mysqli($host,$user,$pass,$db_name);
    if ($db->connect_error)
        die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
    return $db;
}

function isPremium ($user) {
	$db = connect();
	$sql = "SELECT * FROM payment
			WHERE user = '$user'";
	return $db->query($sql)->num_rows;
}
?>
