<?php

header('Content-Type: application/json');
require_once ('../database/credentials.php');

global $user, $host, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($host, $user, $psw, $db);

$conn->set_charset('utf8');

if (isset($_POST['id'])) {

    $sql = "SELECT o.distanza_percorsa, o.tipo, o.tariffa, o.data_ora, s.via 
    FROM operazione AS o 
    JOIN stazione AS s ON o.id_stazione = s.codice 
    WHERE o.id_cliente = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_POST['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        $json = array("status" => "error", "message" => "nessuna operazione trovata");
    } else {
        $operazioni = array();
        while ($rowData = $result->fetch_assoc()) {
            $operazioni[] = $rowData;
        }
        $json = array("status" => "success", "message" => $operazioni);
    }

} else {
    $json = array("status" => "error", "message" => "manca id");
}


echo json_encode($json);