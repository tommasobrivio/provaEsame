<?php
require_once ("../database/credentials.php");
header('Content-Type: application/json');

global $host, $user, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (
    isset($_POST['slot']) && isset($_POST['regione']) && isset($_POST['provincia']) && isset($_POST['comune'])
    && isset($_POST['cap']) && isset($_POST['via'])
) {

    //salvo tutti i dati passati in POST
    $slot = $_POST['slot'];
    $regione = $_POST['regione'];
    $provincia = $_POST['provincia'];
    $comune = $_POST['comune'];
    $cap = $_POST['cap'];
    $via = $_POST['via'];
    

    //creo connessione al database comuni
    $conn = new mysqli($host, $user, $psw, 'gi_db_comuni');

    $conn->set_charset("utf8");

    //prendo il nome regione avendo il codice
    $stmt = $conn->prepare('SELECT denominazione_regione FROM gi_regioni WHERE codice_regione=?');
    $stmt->bind_param("s", $regione);
    $stmt->execute();
    $regione=($stmt->get_result())->fetch_assoc()['denominazione_regione'];
    //chiudi connessione 
    $stmt->close();

    //prendo il nome provincia avendo il codice
    $stmt = $conn->prepare('SELECT denominazione_provincia FROM gi_province WHERE sigla_provincia=?');
    $stmt->bind_param("s", $provincia);
    $stmt->execute();
    $provincia=($stmt->get_result())->fetch_assoc()['denominazione_provincia'];
    //chiudi connessione 
    $stmt->close();

    //prendo il nome comune avendo il cap
    $stmt = $conn->prepare('SELECT denominazione_ita FROM gi_comuni_cap WHERE cap=?');
    $stmt->bind_param("s", $comune);
    $stmt->execute();
    $comune=($stmt->get_result())->fetch_assoc()['denominazione_ita'];
    //chiudi connessione 
    $stmt->close();

    $conn->close();

    //creo connessione al database stazione_biciclette
    $conn = new mysqli($host, $user, $psw, $db);

    $conn->set_charset("utf8");
    //inserisco l'utente
    $sql = "INSERT INTO stazione (slot, regione, provincia, citta, cap, via)
        VALUES(?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssis", $slot, $regione, $provincia, $comune, $cap, $via);
    
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

