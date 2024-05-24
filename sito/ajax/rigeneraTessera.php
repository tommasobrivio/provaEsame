<?php

// SE UNA TESSERA E' STATA BLOCCATA AVRA' IL NUMERO DELLA TESSERA NEGATIVO

if (!isset($_SESSION))
    session_start();

header('Content-Type: application/json');
require_once ('../database/credentials.php');

global $user, $host, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!isset($_POST['id'])) {
    $json = array("status" => "error", "message" => "parametri mancanti");
} else {

    $conn = new mysqli($host, $user, $psw, $db);

    $conn->set_charset('utf8');

    // CONTROLLO SE ESISTE L'UTENTE
    $query = 'SELECT * FROM clienti WHERE ID=?';

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    if ($result->num_rows == 0) {
        $json = array("status" => "error", "message" => "nessun cliente trovato");
    } else {

        $row = $result->fetch_assoc();

        // INSERISCO UN NUOVO UTENTE PER GENERARE AUTOMATICAMENTE UNA NUOVA TESSERA GRAZIE AL TRIGGER CHE INCREMENTA DI 1 RISPETTO AL NUMERO PIU' ALTO
        $query = "INSERT INTO clienti (email, username, password, nome, cognome, carta_credito, regione, provincia, citta, cap, via)
        VALUES('','','',null,null,'',null,null,null,null, null)";

        $stmt = $conn->prepare($query);
        
        if(!$stmt->execute())
            echo 'errore nella insert';

        $stmt->close();

        //PRENDO L'ULTIMO CLIENTE INSERITO PER PRENDERE IL NUOVO NUMERO TESSERA
        $query = 'SELECT * FROM clienti ORDER BY ID desc LIMIT 1';

        $stmt = $conn->prepare($query);
        
        if(!$stmt->execute())
            echo 'errore nella select ultimo utente';

        $result=$stmt->get_result()->fetch_assoc();

        $stmt->close();

        $lastId=$result['ID'];
        
        $newTessera= $result['numeroTessera'];
        
        //CANCELLO L'UTENTE VUOTO
        $query = 'DELETE FROM clienti WHERE ID =?';

        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $lastId);
        
        if(!$stmt->execute())
            echo 'errore nella delete';

        $stmt->close();

        //MODIFICO IL NUMERO TESSERA DELL'UTENTE CHE NE HA BISOGNO UNA NUOVA
        $query = 'UPDATE clienti SET numeroTessera=? WHERE ID =?';

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $newTessera, $_POST['id']);
        
        if(!$stmt->execute())
            echo 'errore nella update';

        $stmt->close();

        $json = array("status" => "success", "message" => "utente modificato con nuova carta");
    }
}


echo json_encode($json);
