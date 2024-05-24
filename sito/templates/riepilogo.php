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
    <title>Riepilogo</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../cdn/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css" />
    <script src="../script/request.js"></script>
    <script src="../script/homeClient.js"></script>

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
            let id = params['user'];

            let data = await request('POST', '../ajax/getOperationsClient.php', { id: id });

            if (data['status'] === 'success') {
                let operations = data['message'];
                let table
                    = '';

                operations.forEach(operation => {
                    table += '<tr>' +
                        '+<td>' + operation['distanza_percorsa'] + '</td>' +
                        '<td>' + operation['tipo'] + '</td>' +
                        '<td>' + operation['tariffa'] + '</td>' +
                        '<td>' + operation['data_ora'] + '</td>' +
                        '<td>' + operation['via'] + '</td>' +
                        '</tr>';
                });

                $('#operazioni').append(table);
            }
        });


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
                        <a class="nav-link" aria-current="page"
                            href="profile.php?user=<?php echo $_SESSION['ID']; ?>">Profilo</a>
                    </li>
                </ul>
            </div>
            <a href="logout.php"><button class="btn btn-dark">LOGOUT</button></a>
            <?php if(isset($_SESSION['statoTessera']) && $_SESSION['statoTessera']=='bloccata'){
                echo 'Tessera bloccata';
            }
            else{
                echo '<button id="segnalaCarta" class="btn btn-dark" onclick="bloccaCarta('.$_SESSION['ID'].')">SEGNALA CARTA</button>';
            }?>
        </div>
    </nav>
    <div class="container">
        <h2>Riepilogo Operazioni</h2>
        <table id="operazioni" class="table">
            <tr>
                <th>Distanza Percorsa</th>
                <th>Tipo</th>
                <th>Tariffa</th>
                <th>Data e Ora</th>
                <th>Stazione</th>
            </tr>
        </table>
    </div>
</body>

</html>