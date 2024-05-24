<?php

if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['logged']))
    header('Location: login.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica stazione</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../cdn/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css" />
    <script src="../script/request.js"></script>
    <script src="../script/manageBycicles.js"></script>
    <script src="../script/homeAdmin.js"></script>
    <link rel="stylesheet" href="../css/style.css">

    <script>

        $(document).ready(async function () {
            
            await visualizzaCarteBloccate();

        })
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="stations.php">Gestione stazioni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bicycles.php">Gestione biciclette</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="utentiBloccati.php">Utenti bloccati</a>
                    </li>
                </ul>
            </div>
            <a href="logout.php"><button class="btn btn-dark">LOGOUT</button></a>
        </div>
    </nav>
    <div class="container">
        
        <div class="row-mb--3">
            <div class="col col-12">
                <table class="table" id="utentiBloccati">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Numero Tessera</th>
                        <th></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
