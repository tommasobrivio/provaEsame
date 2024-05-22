<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../cdn/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css" />
    <script src="../script/showComuni.js"></script>

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

        $(document).ready(function () {
            let params = getQueryParams();

            let codice = params['user'];

            mostraRegioni();
            $.post('../ajax/getClient.php', { id: codice }, function (data) {

                if (data['status'] == 'success') {

                    $('#nome').val(data['message']['nome']);
                    $('#cognome').val(data['message']['cognome']);
                    $('#username').val(data['message']['username']);
                    $('#password').val(data['message']['password']);
                    $('#email').val(data['message']['email']);
                    $('#cartaCredito').val('*'.repeat(12) + data['message']['carta_credito'].slice(-4));

                    let regione;
                    $.get('../ajax/getRegioni.php', { nome: data['message']['regione'] }, function (data1) {

                        regione=data1;
                        $('#selectRegione').val(data1);
                    })
                    mostraProvince(regione);
                    $.get('../ajax/getProvince.php', { nome: data['message']['provincia'] }, function (data2) {

                        mostraComuni(data2);
                        $('#selectProvincia').val(data2);
                    })

                }
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
                        <a class="nav-link" aria-current="page"
                            href="profile.php?user=<?php echo $_SESSION['ID']; ?>">Profilo</a>
                    </li>
                </ul>
            </div>
            <a href="logout.php"><button class="btn btn-dark">LOGOUT</button></a>
        </div>
    </nav>

    <div class="container" style="padding-top:2% !important">

        <div class="row">

            <div class="form col col-4">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" placeholder="nome" class="form-control border-black input">
            </div>
            <div class="form col col-4">
                <label for="cognome">Cognome:</label>
                <input type="text" id="cognome" placeholder="cognome" class="form-control border-black input">
            </div>

        </div><br>

        <div class="row">

            <div class="form col col-4">
                <label for="username">Username:</label>
                <input type="text" id="username" placeholder="username" class="form-control border-black input">
            </div>
            <div class="form col col-4">
                <label for="password">Password:</label>
                <input type="password" id="password" placeholder="password" class="form-control border-black input">
            </div>
            <div class="form col col-4">
                <label for="email">Email:</label>
                <input type="text" id="email" placeholder="email" class="form-control border-black input">
            </div>

        </div><br>

        <div class="row">

            <div class="form col col-4">
                <label for="cartaCredito">Carta di Credito:</label>
                <input type="text" id="cartaCredito" placeholder="cartaCredito" class="form-control border-black input">
            </div>

        </div><br>

        <div class="row">

            <div class="form col col-4">
                <label for="selectRegione">Regione:</label>
                <select id="selectRegione" class="form-control border-black input"></select>
            </div>
            <div class="form col col-4">
                <label for="selectProvincia">Provincia:</label>
                <select id="selectProvincia" class="form-control border-black input"></select>
            </div>
            <div class="form col col-4">
                <label for="selectComune">Comune:</label>
                <select id="selectComune" class="form-control border-black input"></select>
            </div>

        </div><br>

        <div class="row">
            <div class="form col col-4">
                <label for="cap">Cap:</label>
                <input type="text" id="cap" class="form-control border-black input">
            </div>
            <div class="form col col-4">
                <label for="via">Via:</label>
                <input type="text" id="via" class="form-control border-black input">
            </div>
        </div><br>

        <div class="row">
            <div class="col col-4">
                <button class="btn btn-dark" id="update">Modifica profilo</button>
            </div>
        </div>

    </div><br>

</body>

</html>