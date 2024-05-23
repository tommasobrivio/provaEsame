<?php

require_once ("../database/credentials.php");
header('Content-Type: application/json');

global $host, $user, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (
    isset($_POST['lat']) && isset($_POST['lon']) && isset($_POST['id']) 
) {
    
    //salvo tutti i dati passati in POST
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $id = $_POST['id'];

    //creo connessione al database comuni
    $conn = new mysqli($host, $user, $psw, $db);

    $conn->set_charset("utf8");

        $sql = "UPDATE stazione SET latitudine=?, longitudine=? WHERE codice=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $lat, $lon, $id);
    
    $stmt->execute();

    if($stmt->affected_rows>0)
        //messaggio di risposta
        $json = array("status" => "success", "message" => "stazione modificato");
    else   
        //messaggio di risposta
        $json = array("status" => "error", "message" => "stazione non modificato");
    
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