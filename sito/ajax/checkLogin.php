<?php

if(!isset($_SESSION))
    session_start();

header('Content-Type: application/json');
require_once ('../database/credentials.php');

global $user, $host, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if(!isset($_POST['username']) || !isset($_POST['password'])){
    $json = array("status" => "error", "message" => "parametri mancanti");
}
else{
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli($host, $user, $psw, $db);

    $conn->set_charset('utf8');

    if (str_contains($username, "_"))
    {
        $select = "SELECT * FROM clienti WHERE username = ? AND password = md5(?)";
        $_SESSION["role"] = "client";
    }
    else if (str_contains($username, "."))
    {
        $select = "SELECT * FROM admin WHERE username = ? AND password = md5(?)";
        $_SESSION["role"] = "admin";
    }
    else
    {
        $json = array("status" => "error", "message" => "nessun utente trovato1");
        echo json_encode($json);
        return;
    }

    $stmt = $conn->prepare($select);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        $json = array("status" => "error", "message" => "nessun utente trovato");
    } else {

        $_SESSION['logged'] = true;
        $_SESSION['username']=$username;
        $_SESSION["ID"] = $result->fetch_assoc()["ID"];

        $json = array("status" => "success", "message" => "cliente trovato");
    }
}

echo json_encode($json);
