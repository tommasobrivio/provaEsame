<?php

require_once ('../sito/database/credentials.php');

global $user, $host, $psw, $db;

$conn = new mysqli($host, $user, $psw, $db);

function calcolaTariffa($dInizio, $dFine)
{
    $inizio = strtotime($dInizio);
    $fine = strtotime($dFine);
    $differenza = ($fine - $inizio) / 60;

    $tariffa = 0.05; // Costo per minuto
    return $differenza * $tariffa;
}

function calcolaDistanza($lat1, $lon1, $lat2, $lon2)
{
    $raggio = 6371; //raggio della terra
    $distLat = deg2rad($lat2 - $lat1);
    $distLon = deg2rad($lon2 - $lon1);
    $x = sin($distLat / 2) * sin($distLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($distLon / 2) * sin($distLon / 2);
    $z = 2 * atan2(sqrt($x), sqrt(1 - $x));
    $distanza = $raggio * $z;
    return $distanza;
}


//noleggio della bicicletta

if (isset($_GET['tipo']) && $_GET['tipo'] == "noleggio") {
    
    if (isset($_GET['id_bicicletta']) && isset($_GET['id_cliente'])) {
        $tipo = $_GET['tipo'];
        $idCliente = intval($_GET['id_cliente']);
        $idBicicletta = intval($_GET['id_bicicletta']);
        //codice fisso perchè faccio finta di essere in una stazione
        $idStazione = 1002;
        $currentTime = date("Y-m-d H:i:s");

        // query di inserimento
        $query = "INSERT INTO operazione (tipo, data_ora, id_cliente, id_bicicletta, id_stazione) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);


        $stmt->bind_param("ssiii", $tipo, $dataOra, $idCliente, $idBicicletta, $idStazione);

        // Esegui la query
        $stmt->execute();

        // Chiude lo statement
        $stmt->close();

    } else {
        echo "Parametri mancanti";
    }

    
} else if (isset($_GET['tipo']) && $_GET['tipo'] == "riconsegna") {
    if (isset($_GET['id_bicicletta']) && isset($_GET['id_cliente'])) {
        $tipo = $_GET['tipo'];
        $idCliente = intval($_GET['id_cliente']);
        $idBicicletta = intval($_GET['id_bicicletta']);
        $idStazione = 1002;
        $dataOraRiconsegna = date("Y-m-d H:i:s");

        // Ottieni la data di inizio del noleggio
        $query = "SELECT data_ora FROM operazione WHERE id_bicicletta = ? AND id_cliente = ? AND tipo = 'noleggio' ORDER BY data_ora DESC LIMIT 1";
        $stmt = $conn->prepare($query);

        $stmt->bind_param("ii", $idBicicletta, $idCliente);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $rowData = $result->fetch_assoc();

        $tariffa = calcolaTariffa($rowData['data_ora'], $dataOraRiconsegna);
        $distanzaPercorsa=1000;
        
        // Inserisci i dati della consegna
        $query = "INSERT INTO operazione (tipo, distanzaPercorsa, tariffa, codiceBicicletta, codiceStazione, codiceUtente, dataOra) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);


        $stmt->bind_param("sidiiis", $tipo, $distanzaPercorsa, $tariffa, $codiceBicicletta, $codiceStazione, $idCliente, $dataOraConsegna);
        $stmt->execute();


        $stmt->close();


    } else {
        echo "Parametri mancanti";
    }
}