<?php

header('Content-Type: application/json');
require_once ('../database/credentials.php');

global $user, $host, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($host, $user, $psw, $db);

$conn->set_charset('utf8');

if(isset($_POST['id'])){
    $sql = "SELECT * FROM bicicletta WHERE ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_POST['id']);
}
else{
    $sql = "SELECT * FROM bicicletta";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows < 1) {
    $json = array("status" => "error", "message" => "nessuna bicicletta trovata");
} else {
    $operazioni = array();
    while ($rowData = $result->fetch_assoc()) {
        $operazioni[] = $rowData;
    }
    $json = array("status" => "success", "message" => $operazioni);
}

echo json_encode($json);