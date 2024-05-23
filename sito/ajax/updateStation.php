<?php

require_once ("../database/credentials.php");
header('Content-Type: application/json');

global $host, $user, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//print_r($_POST);
if (
    isset($_POST['slot'])  && isset($_POST['codice']) 
) {
    
    //salvo tutti i dati passati in POST
    $slot = $_POST['slot'];
    $id = $_POST['codice'];

    //creo connessione al database comuni
    $conn = new mysqli($host, $user, $psw, $db);

    $conn->set_charset("utf8");

    //modifico l'utente
    
    $sql = "UPDATE stazione SET slot=?  WHERE codice=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $slot, $id);
    
    $stmt->execute();

    if($stmt->affected_rows>0)
        //messaggio di risposta
        $json = array("status" => "success", "message" => "stazione modificato");
    else   
        //messaggio di risposta
        $json = array("status" => "success", "message" => "stazione non modificato, i dati erano uguali");
    
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