<?php
if($_SERVER["REQUEST_METHOD"] == "POST"):
    require_once 'functions.php';
    $db = connect();

    $email = $db->real_escape_string($_POST['input-email']);
    $password = $db->real_escape_string($_POST['input-password']);
    $accessLevel = $db->real_escape_string($_POST['access-level']);
    $sql = "SELECT email, password
            FROM $accessLevel
            WHERE email = '$email' AND password = PASSWORD('$password')";

    if ($db->query($sql)->num_rows):
        session_start();
        $_SESSION["$accessLevel"] = $email;
        $result = ["success" => true, "accessLevel" => $accessLevel];
    else:
        $result = ["success" => false, "message" => "Email o contraseña incorrecta. Por favor, verifique los datos y vuelva a intentarlo."];
    endif;
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($result);
endif;
?>
