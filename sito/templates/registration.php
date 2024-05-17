<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../script/registration.js"></script>
    <script src="../cdn/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css" />
    <script>

        $(document).ready(function () {

            mostraRegioni();

            $('#selectRegione').change(function () {
                mostraProvince($(this).val());
            });

            $('#selectProvincia').change(function () {
                mostraComuni($(this).val());
            });

        });

    </script>

</head>

<body style="margin-top:2% !important">
    <div class="container">

        <div class="row">

            <div class="form col col-4">
                <input type="text" id="nome" placeholder="nome" class="form-control border-black input">
            </div>
            <div class="form col col-4">
                <input type="text" id="cognome" placeholder="cognome" class="form-control border-black input">
            </div>

        </div><br>

        <div class="row">

            <div class="form col col-4">
                <input type="text" id="username" placeholder="username" class="form-control border-black input">
            </div>
            <div class="form col col-4">
                <input type="text" id="password" placeholder="password" class="form-control border-black input">
            </div>
            <div class="form col col-4">
                <input type="text" id="email" placeholder="email" class="form-control border-black input">
            </div>

        </div><br>

        <div class="row">

            <div class="form col col-4">
                <input type="number" id="cartaCredito" placeholder="cartaCredito" class="form-control border-black input">
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

        </div><br>

        <div class="row">

            <div class="form col col-4">
                <input type="number" id="cap" placeholder="cap" class="form-control border-black input">
            </div>
            <div class="form col col-4">
                <input type="text" id="via" placeholder="indirizzo" class="form-control border-black input">
            </div>

        </div><br>

        <div class="row">

            <div class="form col col-4">
                <button class="btn btn-dark">REGISTRA</button> 
            </div>

        </div><br>

        <a href="home.php"> <button class="btn btn-dark">Torna indietro</button></a>
    </div>

</body>

</html>