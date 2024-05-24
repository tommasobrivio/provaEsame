<?php

// SE UNA TESSERA E' STATA BLOCCATA AVRA' IL NUMERO DELLA TESSERA NEGATIVO

if(!isset($_SESSION))
    session_start();

header('Content-Type: application/json');
require_once ('../database/credentials.php');

global $user, $host, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if(!isset($_POST['id'])){
    $json = array("status" => "error", "message" => "parametri mancanti");
}
else{
    
    $id = $_POST['id'];

    $conn = new mysqli($host, $user, $psw, $db);

    $conn->set_charset('utf8');

    $query='SELECT * FROM clienti WHERE numeroTessera < 0 ORDER BY numeroTessera asc LIMIT 1';

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $result=$stmt->get_result();

    //SE E' LA PRIMA AD ESSERE BLOCCATA SETTO -1
    if($result->num_rows==0){
        $query='UPDATE clienti SET numeroTessera=-1 WHERE ID=?';

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($stmt->affected_rows < 1){
            $json = array("status"=> "error", "message"=> "errore nella modifica");
        }
        else
            $json = array("status"=> "success", "message"=> "utente modificato");
    }
    //ALTRIMENTI DIMINUISCO DI 1 IL NUMERO PRENDENDO QUELLO PIU' PRESENTE NEL DB
    else{
        $newTesseraBloccata=($result->fetch_assoc()['numeroTessera'])-1;

        $query='UPDATE clienti SET numeroTessera=? WHERE ID=?';

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $newTesseraBloccata, $id);
        $stmt->execute();

        if($stmt->affected_rows < 1){
            $json = array("status"=> "error", "message"=> "errore nella modifica");
        }
        else
            $json = array("status"=> "success", "message"=> "utente modificato");
    }
}

$_SESSION['statoTessera']='bloccata';

echo json_encode($json);
