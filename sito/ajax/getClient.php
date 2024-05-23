<?php

header('Content-Type: application/json');
require_once ('../database/credentials.php');

global $user, $host, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Crea connessione al database
$conn = new mysqli($host, $user, $psw, $db);

if (!isset($_POST["id"])) {
    $json = array("status" => "error", "message" => "mancano parametri");
} else {

    $id=$_POST["id"];

    $query='SELECT * FROM clienti WHERE ID=?';
    $stmt=$conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows != 1) {
        $json = array("status" => "error", "message" => "nessun utente trovato");
    }
    else {
        $rowData = $result->fetch_assoc();
        $json = array("status" => "success", "message" => $rowData);
    }

    // Chiudi la connessione al database
    $conn->close();
}
// Ritorna i dati in formato JSON
echo json_encode($json);