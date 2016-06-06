<?php
function connect ($host = 'localhost', $user = 'root', $pass = '', $db_name = 'couchinn') {
    $db = new mysqli($host,$user,$pass,$db_name);
    if ($db->connect_error)
        die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
    return $db;
}
?>
