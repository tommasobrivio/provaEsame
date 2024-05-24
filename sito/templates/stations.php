<?php

if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['logged']))
    header('Location: login.php');
?>

<!DOCTYPE html>
<html lang="en" style="height:100% !important">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stazioni</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../cdn/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css" />
    <script src="../script/showComuni.js"></script>
    <script src="../script/manageStations.js"></script>
    <script src="../script/request.js"></script>
    <link rel="stylesheet" href="../css/style.css">

    <script>
        function updateStation(id) {
            window.location.href = 'updateStation.php?codice=' + id;
        }

        async function deleteStation(id) {
            let data = await request('POST', '../ajax/delete.php', { table: 'stazione', id: id });
            if (data['status'] == 'success') {
                window.location.reload();
            }
        }


        $(document).ready(async function () {

            let table = '';
            let data = await request('POST', '../ajax/getStations.php', {})
            data['message'].forEach(element => {
                table += "<tr><td>" + element['codice'] + "</td>" +
                    "<td>" + element['slot'] + "</td><td>" + element['citta'] + "</td>" +
                    "<td>" + element['via'] + "</td><td><button onclick='updateStation(" + element["codice"] + ")' class='update btn btn-dark'>MODIFICA</button></td>" +
                    "<td><button onclick='deleteStation(" + element["codice"] + ")' class='delete btn btn-dark'>ELIMINA</button></td></tr>";
            });

            $('#stazioni').append(table);


            await mostraRegioni();

            $('#selectRegione').change(async function () {
                await mostraProvince($(this).val());
            });

            $('#selectProvincia').change(async function () {
                await mostraComuni($(this).val());
            });

            $('#selectComune').change(function () {
                $('#cap').val($(this).val());
            });

            let check = false;
            $('#aggiungi').click(async function () {
                check = await aggiungi();
                if (check)
                    await setLatLon();
            });
        });
    </script>
</head>

<body style="height:100% !important;">
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
        <table id="stazioni" class="table">
            <tr>
                <th>Codice</th>
                <th>Slot</th>
                <th>Città</th>
                <th>Via</th>
                <th></th>
                <th></th>
            </tr>
        </table>

        <div class="row">
            <h2>Aggiungi stazione</h2><br>
            <div class="row">
                <div class="form col col-4">
                    <input type="number" id="slot" class="form-control border-black input" placeholder="numero slot">
                </div>
            </div><br>
            <div class="row">
                <div class="form col col-4">
                    <select id="selectRegione" class="form-control border-black input"></select>
                </div>
                <div class="form col col-4">
                    <select id="selectProvincia" class="form-control border-black input"></select>
                </div>
                <div class="form col col-4">
                    <select id="selectComune" class="form-control border-black input"></select>
                </div>
            </div>
            <div class="row">
                <div class="form col col-4">
                    <input type="text" id="cap" placeholder="cap" class="form-control border-black input">
                </div>
                <div class="form col col-4">
                    <input type="text" id="via" placeholder="indirizzo" class="form-control border-black input">
                </div>
            </div><br>
            <div class="row">
                <div class="form col col-4">
                    <button class="btn btn-dark" id="aggiungi">AGGIUNGI</button>
                </div>
            </div><br>
        </div>
    </div>
</body>

</html>