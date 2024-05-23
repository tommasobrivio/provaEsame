<?php
if (!isset($_SESSION))
    session_start();

function homeGuest()
{
    echo '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    </ul>
                </div>
                <a href="login.php"><button class="btn btn-dark">LOGIN</button></a>
            </div>
        </nav>';
}

function homeAdmin()
{
    echo '
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
        ';
}

function homeClient()
{
    echo '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="profile.php?user='.$_SESSION['ID'].'">Profilo</a>
                    </li>
                </ul>
            </div>
            <a href="logout.php"><button class="btn btn-dark">LOGOUT</button></a>
        </div>
    </nav>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../cdn/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="../cdn/bootstrap.min.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>

        function findLatLonAddMarker(address, mymap) {
            var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);

            $.getJSON(url, function (data) {
                if (data.length > 0) {
                    var lat = parseFloat(data[0].lat);
                    var lon = parseFloat(data[0].lon);
                    L.marker([lat, lon]).addTo(mymap).bindPopup(address);
                }
            });
        }

        function loadMap() {
            // Inizializza la mappa
            var mymap = L.map('mapid').setView([45.738777965232245, 9.129964082099326], 13);

            // Aggiungi la mappa di OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(mymap);

            // Aggiungi un marker alla mappa
            $.get('../ajax/getStations.php', {}, function (data) {
                //prendere le stazioni, salvarle in un file json e creare vari marker per ogni stazione
                data['message'].forEach(element => {
                    findLatLonAddMarker(element['via'] + ', ' + element['citta'] + ', ' + element['provincia'] + ', ' + element['regione'] + ', ' + 'Italy', mymap);
                });
            })
        }


        $(document).ready(function () {
            loadMap();
        });
    </script>

</head>

<body>

    <?php
    if (isset($_SESSION['logged'])) {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == 'client') {
                echo homeClient();
            } else {
                echo homeAdmin();
            }
        } else {
            echo 'errore nel session "role"';
        }

    } else {
        echo homeGuest();
    }
    ?>
    <div class="container">



        <div id="mapid" style="width: 100%; height: 400px;"></div>

    </div>

</body>

</html>