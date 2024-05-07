<?php
if (isset($_SESSION))
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        $(document).ready(function () {
            // Inizializza la mappa
            var mymap = L.map('mapid').setView([45.738777965232245, 9.129964082099326], 13);

            // Aggiungi la mappa di OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(mymap);

            // Aggiungi un marker alla mappa
            $.get('./ajax/getStazioni.php', {}, function(data){
                //prendere le stazioni, salvarle in un file json e creare vari marker per ogni stazione
            })
            var marker = L.marker([45.738777965232245, 9.129964082099326]).addTo(mymap);
            marker.bindPopup('A pretty CSS3 popup.<br> Easily customizable.').openPopup();
        });
    </script>

</head>

<body>
    <div class="container">

        <?php
        if (isset($_SESSION['logged'])) {
            echo "Benvenuto " . $_SESSION['username'];
            echo homeClient();
        } /*else {
            echo homeGuest();
        }*/
        ?>

        <div id="mapid" style="width: 100%; height: 400px;"></div>

    </div>

</body>

</html>