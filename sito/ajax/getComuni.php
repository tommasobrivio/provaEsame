<?php

header('Content-Type: application/json');
require_once('../database/credentials.php');

global $user, $host, $psw, $db;

$db='gi_db_comuni';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Crea connessione al database
$conn = new mysqli($host, $user, $psw, $db);

if(isset($_GET["codice"])) {
    $stmt = $conn->prepare("SELECT * FROM gi_comuni WHERE sigla_provincia=?");
    $stmt->bind_param("s", $_GET["codice"]);
} else {
    $stmt = $conn->prepare("SELECT * FROM gi_comuni");
}

$stmt->execute();
$result = $stmt->get_result();

// Crea un array per contenere i risultati
$comuni = array();

if ($result->num_rows > 0) {
    // Riempi l'array con i dati della tabella "gi_comuni"
    while ($row = $result->fetch_assoc()) {
        $comuni[] = $row;
    }
}

// Chiudi la connessione al database
$conn->close();

// Ritorna i dati in formato JSON
echo json_encode($comuni);