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
    <script src="../script/request.js"></script>
    <script src="../script/manageBycicles.js"></script>
    <link rel="stylesheet" href="../css/style.css">

    <script>
        function updateBicycle(id) {
            window.location.href = 'updateBicycle.php?id=' + id;
        }

        async function deleteBicycle(id) {
            let data = await request('POST', '../ajax/delete.php', { table: 'bicicletta', id: id })
            if (data['status'] == 'success') {
                window.location.reload();
            }
        }


        $(document).ready(async function () {

            let table = '';
            let data = await request('POST', '../ajax/getBicycle.php', {});

            data['message'].forEach(element => {
                table += "<tr><td>" + element['latitudine'] + "</td>" +
                    "<td>" + element['longitudine'] + "</td><td>" + element['gps'] + "</td>" +
                    "<td>" + element['stato'] + "</td><td>" + element['RFID'] + "</td>" +
                    "<td><button onclick='updateBicycle(" + element["ID"] + ")' class='update btn btn-dark'>MODIFICA</button></td>" +
                    "<td><button onclick='deleteBicycle(" + element["ID"] + ")' class='delete btn btn-dark'>ELIMINA</button></td></tr>";
            });

            $('#biciclette').append(table);


            data = await request('POST', '../ajax/getStations.php', {});

            await showStations(data);

            $('#aggiungi').click(async function () {
                await aggiungi();
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
                </ul>
            </div>
            <a href="logout.php"><button class="btn btn-dark">LOGOUT</button></a>
        </div>
    </nav>
    <div class="container">
        <table id="biciclette" class="table">
            <tr>
                <th>Latitudine</th>
                <th>Longitudine</th>
                <th>Gps</th>
                <th>Stato</th>
                <th>RFID</th>
                <th></th>
                <th></th>
            </tr>
        </table>
        <h2>Aggiungi bicicletta</h2><br>
        <div class="row">
            <div class="col-md-6">
                <select id="stazione" class="form-control border-black input" placeholder="stazione"></select>
            </div>
            <div class="col-md-6">
                <select id="stato" class="form-control border-black input" placeholder="stato">
                    <option value="" selected disabled>Scegli lo stato</option>
                    <option value="disponibile">Disponibile</option>
                    <option value="non disponibile">Non disponibile</option>
                    <option value="in manutenzione">In manutenzione</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form col col-4">
                <button class="btn btn-dark" id="aggiungi">AGGIUNGI</button>
            </div>
        </div><br>
    </div>
</body>

</html>