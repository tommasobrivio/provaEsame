<?php

require_once ('../sito/database/credentials.php');

global $user, $host, $psw, $db;

$conn = new mysqli($host, $user, $psw, $db);

$idStazione = 1002;

// Query per ottenere tutte le biciclette disponibili nel parcheggio specificato

$query = "SELECT id_bicicletta
    FROM operazione AS o1
    JOIN bicicletta AS b ON o1.id_bicicletta = b.ID
    WHERE o1.idStazione = ?
      AND o1.tipo = 'riconsegna'
      AND o1.data_ora = (
          SELECT MAX(o2.data_ora)
          FROM operazione AS o2
          WHERE o1.id_bicicletta = o2.id_bicicletta
      )
";

$stmt = $conn->prepare($query);


$stmt->bind_param("i", $idStazione);
$stmt->execute();
$result = $stmt->get_result();

$bicicletteDisponibili = [];
while ($row = $result->fetch_assoc()) {
    $bicicletteDisponibili[] = $row;
}

$stmt->close();

header('Content-Type: application/json');
echo json_encode($bicicletteDisponibili);


$conn->close();
