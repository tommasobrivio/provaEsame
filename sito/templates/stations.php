<?php

if(!isset($_SESSION))
    session_start();

if(!isset($_SESSION['logged'])) 
    header('Location: login.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stazioni</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../cdn/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css" />

    <script>
        function updateStation(id) {
            window.location.href = 'udpate.php?codice=' + id;
        }

        function deleteStation(id) {
            $.post('../ajax/delete.php', { table: 'stazione', id: id }, function (data) {
                if (data['status'] == 'success') {
                    window.location.reload();
                }
            })
        }

        $(document).ready(function () {

            let table = '';
            $.post('../ajax/getStazioni.php', {}, function (data) {
                data['message'].forEach(element => {
                    table += "<tr><td>" + element['codice'] + "</td>" +
                        "<td>" + element['slot'] + "</td><td>" + element['citta'] + "</td>" +
                        "<td>" + element['via'] + "</td><td><button onclick='updateStation(" + element["codice"] + ")' class='update btn btn-dark'>MODIFICA</button></td>" +
                        "<td><button onclick='deleteStation(" + element["codice"] + ")' class='delete btn btn-dark'>ELIMINA</button></td></tr>";


                });

                $('#stazioni').append(table);
            });
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
                        <a class="nav-link" href="">Gestione slot</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Gestione biciclette</a>
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
    </div>
</body>

</html>