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
            let id = params['id'];

            await getBicycleId(id);

            $('#update').click(async function () {
                await updateBicycle(id);
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
                </ul>
            </div>
            <a href="logout.php"><button class="btn btn-dark">LOGOUT</button></a>
        </div>
    </nav>
    <div class="container">
        <!-- Prima riga: Stato -->
        <div class="row mb-3">
            <div class="form col col-12">
                <label for="stato">Stato:</label>
                <select id="stato" class="form-control border-black input" placeholder="stato">
                    <option value="" selected disabled>Scegli lo stato</option>
                    <option value="disponibile">Disponibile</option>
                    <option value="non disponibile">Non disponibile</option>
                    <option value="in manutenzione">In manutenzione</option>
                </select>
            </div>
        </div>
        
        <!-- Seconda riga: Latitudine e Longitudine -->
        <div class="row mb-3">
            <div class="form col col-6">
                <label for="lat">Latitudine:</label>
                <input type="text" id="lat" placeholder="latitudine" class="form-control border-black input" disabled>
            </div>
            <div class="form col col-6">
                <label for="lon">Longitudine:</label>
                <input type="text" id="lon" placeholder="longitudine" class="form-control border-black input" disabled>
            </div>
        </div>
        
        <!-- Terza riga: GPS e RFID -->
        <div class="row mb-3">
            <div class="form col col-6">
                <label for="gps">Gps:</label>
                <input type="text" id="gps" placeholder="gps" class="form-control border-black input">
            </div>
            <div class="form col col-6">
                <label for="RFID">RFID:</label>
                <input type="text" id="RFID" placeholder="RFID" class="form-control border-black input">
            </div>
        </div>
        
        <!-- Pulsante Modifica -->
        <div class="row">
            <div class="form col col-12">
                <button id="update" class="btn btn-dark">Modifica</button>
            </div>
        </div>
    </div>
</body>

</html>
