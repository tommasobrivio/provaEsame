<?php

header('Content-Type: application/json');
require_once('../database/credentials.php');

global $user, $host, $psw, $db;

$db='gi_db_comuni';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Crea connessione al database
$conn = new mysqli($host, $user, $psw, $db);

if(isset($_GET["codice"])) {
    $stmt = $conn->prepare("SELECT * FROM gi_regioni WHERE codice_regione=?");
    $stmt->bind_param("s", $_GET["codice"]);
} else {
    $stmt = $conn->prepare("SELECT * FROM gi_regioni");
}

$stmt->execute();
$result = $stmt->get_result();

// Crea un array per contenere i risultati
$regioni = array();

if ($result->num_rows > 0) {
    // Riempi l'array con i dati della tabella "gi_regioni"
    while ($row = $result->fetch_assoc()) {
        $regioni[] = $row;
    }
}

// Chiudi la connessione al database
$conn->close();

// Ritorna i dati in formato JSON
echo json_encode($regioni);