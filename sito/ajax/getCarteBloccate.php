<?php

// SE UNA TESSERA E' STATA BLOCCATA AVRA' IL NUMERO DELLA TESSERA NEGATIVO

if (!isset($_SESSION))
    session_start();

header('Content-Type: application/json');
require_once ('../database/credentials.php');

global $user, $host, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($host, $user, $psw, $db);

$conn->set_charset('utf8');

$query = 'SELECT * FROM clienti WHERE numeroTessera < 0';

$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    $json = array("status" => "success", "message" => "nessun cliente ha la carta bloccata");
} else {

    $clienti = array();

    while ($rowData = $result->fetch_assoc()) {
        $clienti[] = $rowData;
    }

    $json = array("status"=> "success","message"=>$clienti);
}

echo json_encode($json);
