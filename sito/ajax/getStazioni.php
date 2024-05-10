<?php

header('Content-Type: application/json');
require_once ('../database/credentials.php');

global $user, $host, $psw, $db;

$conn = new mysqli($host, $user, $psw, $db);

$conn->set_charset('utf8');

$sql = "SELECT regione, provincia, citta, via FROM stazione";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows < 1) {
    $json = array("status" => "error", "message" => "nessuna stazione trovata");
} else {
    $stazioni = array();
    while ($row = $result->fetch_assoc()) {
        $stazioni[] = $row;
    }
    $json = array("status" => "success", "message" => $stazioni);
}

echo json_encode($json);
