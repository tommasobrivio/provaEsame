<?php
if (!isset($_SESSION))
    session_start();

function homeGuest(){
    echo '<div class="form col col-4">
            <input type="text" placeholder="username" id="username" class="form-control border-black input">
            <input type="password" placeholder="password" id="password" class="form-control border-black input"><br>
            <button id="login" class="btn btn-dark">LOGIN</button><br><br>
            Non sei registrato? <a href="registration.php" style="color:black !important"><button class="btn btn-dark">REGISTRATI</button></a>

          </div><br><br>';
}

function homeClient(){
    echo '<div>
            <a href="logout.php"><button class="btn btn-dark">LOGOUT</button></a>
          </div><br><br>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../cdn/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="../cdn/bootstrap.min.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>

        function findLatLonAddMarker(address, mymap){
            var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);

            $.getJSON(url, function(data) {
                if (data.length > 0) {
                var lat = parseFloat(data[0].lat);
                var lon = parseFloat(data[0].lon);
                L.marker([lat, lon]).addTo(mymap).bindPopup(address);
                }
            });
        }

        function loadMap(){
            // Inizializza la mappa
            var mymap = L.map('mapid').setView([45.738777965232245, 9.129964082099326], 13);

            // Aggiungi la mappa di OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(mymap);

            // Aggiungi un marker alla mappa
            $.get('../ajax/getStazioni.php', {}, function(data){
                //prendere le stazioni, salvarle in un file json e creare vari marker per ogni stazione
                data['message'].forEach(element => {
                    findLatLonAddMarker(element['via'] + ', ' + element['citta'] + ', ' + element['provincia'] + ', ' + element['regione'] + ', ' + 'Italy', mymap);
                });
            })
        }


        $(document).ready(function () {
            loadMap();

            $('#login').click(function(){
                var username = $('#username').val();
                var password = $('#password').val();

                if(username==null || username=='' || password==null || password=='')
                    alert('mancano dei dati');

                else{

                    $.post('../ajax/checkLogin.php', {'username': username,'password': password}, function(data){
                        if(data['status'] == 'success'){
                            window.location.reload();
                        }
                        else{
                            console.log(data['message'])
                        }
                    });

                }
            })
        });
    </script>

</head>

<body>
    <div class="container" style="padding-top:2%">

        <?php
        if (isset($_SESSION['logged'])) {
            echo "Benvenuto " . $_SESSION['username'];
            echo homeClient();
        } else {
            echo homeGuest();
        }
        ?>

        <div id="mapid" style="width: 100%; height: 400px;"></div>

    </div>

</body>

</html>