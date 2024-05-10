<?php

if(!isset($_SESSION))
    session_start();

header('Content-Type: application/json');
require_once ('../database/credentials.php');

global $user, $host, $psw, $db;

if(!isset($_POST['username']) || !isset($_POST['password'])){
    $json = array("status" => "error", "message" => "parametri mancanti");
}
else{

    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli($host, $user, $psw, $db);

    $conn->set_charset('utf8');

    $sql = "SELECT * FROM clienti WHERE username=? AND password=md5(?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        $json = array("status" => "error", "message" => "nessun utente trovato");
    } else {

        $_SESSION['logged'] = true;
        $_SESSION['username']=$username;

        $json = array("status" => "success", "message" => "cliente trovato");
    }
}

echo json_encode($json);
