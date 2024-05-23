    <?php

    require_once ("../database/credentials.php");
    header('Content-Type: application/json');

    global $host, $user, $psw, $db;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if (
        isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])
        && isset($_POST['cartaCredito']) && isset($_POST['regione']) && isset($_POST['provincia']) && isset($_POST['comune'])
        && isset($_POST['cap']) && isset($_POST['via']) && isset($_POST['newPassword']) && isset($_POST['id']) 
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
        $newPassword = $_POST['newPassword'];
        $id = $_POST['id'];

        //creo connessione al database comuni
        $conn = new mysqli($host, $user, $psw, $db);

        $conn->set_charset("utf8");

        //modifico l'utente
        if($newPassword===true)
            $sql = "UPDATE clienti SET email=?, username=?, password=md5(?), nome=?, cognome=?, carta_credito=?, regione=?, provincia=?, 
            citta=?, cap=?, via=?  WHERE ID=?";

        else
            $sql = "UPDATE clienti SET email=?, username=?, password=?, nome=?, cognome=?, carta_credito=?, regione=?, provincia=?, 
            citta=?, cap=?, via=?  WHERE ID=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssisi", $email, $username, $password, $nome, $cognome, $cartaCredito, $regione, $provincia, $comune, $cap, $via, $id);
        
        $stmt->execute();

        if($stmt->affected_rows>0)
            //messaggio di risposta
            $json = array("status" => "success", "message" => "cliente modificato");
        else   
            //messaggio di risposta
            $json = array("status" => "success", "message" => "cliente non modificato, i dati erano uguali");
        
        //chiudi connessione 
        $stmt->close();
        $conn->close();
    }
    //in caso di errore
    else {
        $json = array("status" => "error", "message" => "errore nella modifica");
    }


    //ritorna i dati in formato JSON
    echo json_encode($json);