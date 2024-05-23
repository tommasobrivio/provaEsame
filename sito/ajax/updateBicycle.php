<?php

require_once ("../database/credentials.php");
header('Content-Type: application/json');

global $host, $user, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//print_r($_POST);
if (
    isset($_POST['stato'])  && isset($_POST['id']) && isset($_POST['gps']) && isset($_POST['rfid']) 
) {
    
    //salvo tutti i dati passati in POST
    $stato = $_POST['stato'];
    $id = $_POST['id'];
    $gps = $_POST['gps'];
    $rfid = $_POST['rfid'];

    //creo connessione al database comuni
    $conn = new mysqli($host, $user, $psw, $db);

    $conn->set_charset("utf8");

    //modifico la biciletta
    
    $sql = "UPDATE bicicletta SET stato=?, gps=?, RFID=?  WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $stato, $gps, $rfid, $id);
    
    $stmt->execute();

    if($stmt->affected_rows>0)
        //messaggio di risposta
        $json = array("status" => "success", "message" => "bicicletta modificato");
    else   
        //messaggio di risposta
        $json = array("status" => "success", "message" => "bicicletta non modificato, i dati erano uguali");
    
    //chiudi connessione 
    $stmt->close();
    $conn->close();
}
//in caso di errore
else {
    $json = array("status" => "error", "message" => "errore nella modifica");
}


//ritorna i dati in formato JSON
echo json_encode($json);