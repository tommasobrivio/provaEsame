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
    <script src="../script/manageStations.js"></script>
    <link rel="stylesheet" href="../css/style.css">

    <script>
        function getQueryParams() {
            let params = {};
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);

            for (let [key, value] of urlParams.entries()) {
                params[key] = value;
            }

            return params;
        }

        $(document).ready(async function () {
            let params = getQueryParams();
            let codice = params['codice'];

            await getStazioneCodice(codice);

            $('#update').click(async function () {
                await updateSlot(codice);
            })
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
        <div class="row">
            <div class="form col col-4">
                <label for="slot">Slot:</label>
                <input type="number" id="slot" class="form-control border-black input" placeholder="numero slot">
            </div>
        </div><br>
        <div class="row">
            <div class="form col col-4">
                <label for="regione">Regione:</label>
                <input type="text" id="regione" class="form-control border-black input" disabled>
            </div>
            <div class="form col col-4">
                <label for="provincia">Provincia:</label>
                <input type="text" id="provincia" class="form-control border-black input" disabled>
            </div>
            <div class="form col col-4">
                <label for="comune">Comune:</label>
                <input type="text" id="comune" class="form-control border-black input" disabled>
            </div>
        </div>
        <div class="row">
            <div class="form col col-4">
                <label for="cap">Cap:</label>
                <input type="text" id="cap" placeholder="cap" class="form-control border-black input" disabled>
            </div>
            <div class="form col col-4">
                <label for="via">Via:</label>
                <input type="text" id="via" placeholder="indirizzo" class="form-control border-black input" disabled>
            </div>
        </div><br>
        <div class="row">
            <div class="form col col-4">
                <button id="update" class="btn btn-dark">Modifica</button>
            </div>
        </div>
    </div>
</body>

</html>