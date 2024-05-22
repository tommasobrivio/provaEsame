<?php

if(!isset($_SESSION))
    session_start();

header('Content-Type: application/json');
require_once ('../database/credentials.php');

global $user, $host, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if(!isset($_POST['table']) || !isset($_POST['id'])){
    $json = array("status" => "error", "message" => "parametri mancanti");
}
else{
    
    $table = $_POST['table'];
    $id = $_POST['id'];

    $conn = new mysqli($host, $user, $psw, $db);

    $conn->set_charset('utf8');

    if($table=='stazione')
        $query='DELETE FROM '.$table.' WHERE codice=?';
    else
        $query='DELETE FROM '.$table.' WHERE id=?';

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows < 1) {
        $json = array("status" => "error", "message" => "errore nella cancellazione");
    } else {
        $json = array("status" => "success", "message" => "cancellato con successo");
    }
}

echo json_encode($json);
