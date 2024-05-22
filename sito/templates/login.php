<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../cdn/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css" />

    <script>

        $(document).ready(function () {
            $('#login').click(function () {
                var username = $('#username').val();
                var password = $('#password').val();

                if (username == null || username == '' || password == null || password == '')
                    alert('mancano dei dati');

                else {

                    $.post('../ajax/checkLogin.php', { 'username': username, 'password': password }, function (data) {
                        console.log(data);
                        if (data['status'] == 'success') {
                            window.location.href='home.php';
                        }
                        else {
                            console.log(data['message'])
                        }
                    });

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
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col col-4"></div>
            <div class="col col-4" style="border: black 1px solid; padding:2%; border-radius:20px">
                <input type="text" id="username" placeholder="username" class="form-control border-black"><br>
                <input type="password" id="password" placeholder="password" class="form-control border-black"><br>
                <button class="btn btn-dark" id="login">LOGIN</button><br>
                Non sei registrato? <a href="registration.php" style="color:black !important">Registrati</a>
            </div>
            <div class="col col-4"></div>
        </div>


    </div>
</body>

</html>