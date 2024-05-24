<?php
require_once ("../database/credentials.php");
header('Content-Type: application/json');

global $host, $user, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (
    isset($_POST['lat']) && isset($_POST['lon']) && isset($_POST['stato'])
) {

    //salvo tutti i dati passati in POST
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $stato = $_POST['stato'];

    //creo connessione al database comuni
    $conn = new mysqli($host, $user, $psw, $db);

    $conn->set_charset("utf8");
    //inserisco la bicicletta
    $sql = "INSERT INTO bicicletta (latitudine, longitudine, stato)
        VALUES(?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $lat, $lon, $stato);
    
    $stmt->execute();

    //messaggio di risposta
    $json = array("status" => "success", "message" => "stazione inserita");
    
    //chiudi connessione 
    $stmt->close();
    $conn->close();
}
//in caso di errore
else {
    $json = array("status" => "error", "message" => "errore nell' inserimento");
}


//ritorna i dati in formato JSON
echo json_encode($json);

