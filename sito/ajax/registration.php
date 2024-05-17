<?php

require_once ("../database/credentials.php");
header('Content-Type: application/json');

global $host, $user, $psw, $db;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//creo connessione al database
$conn = new mysqli($host, $user, $psw, $db);

$conn->set_charset("utf8");

if (
    isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])
    && isset($_POST['cartaCredito']) && isset($_POST['regione']) && isset($_POST['provincia']) && isset($_POST['comune'])
    && isset($_POST['cap']) && isset($_POST['via'])
) {

    //salvo tutti i dati passati in POST
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $cartaCredito = $_POST['cartaCredito'];
    $regione = $_POST['regione'];
    $provincia = $_POST['provincia'];
    $comune = $_POST['comune'];
    $cap = $_POST['cap'];
    $via = $_POST['via'];


    //inserisco l'utente
    $sql = "INSERT clienti (email, username, password, nome, cognome, carta_credito, regione, provincia, comune, cap, via)
        VALUES(?,?,md5(?),?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssisssis", $email, $username, $password, $nome, $cognome, $cartaCredito, $regione, $provincia, $comune, $cap, $via);
    
    $stmt->execute();

    //messaggio di risposta
    $json = array("status" => "success", "message" => "cliente inserito");
    
    //chiudi connessione 
    $stmt->close();
    $conn->close();
}
//in caso di errore
else {
    $json = array("status" => "error", "message" => "errore nella registrazione");
}


//ritorna i dati in formato JSON
echo json_encode($data);

?>