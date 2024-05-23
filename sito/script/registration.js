async function registra() {

    var nome = $('#nome').val();
    var cognome = $('#cognome').val();
    var email = $('#email').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var cartaCredito = $('#cartaCredito').val();
    var regione = $('#selectRegione').val();
    var provincia = $('#selectProvincia').val();
    var comune = $('#selectComune').val();
    var cap = $('#cap').val();
    var via = $('#via').val();

    if (nome == '' || cognome == '' || email == '' || username == '' || password == '' || cartaCredito == '' || regione == '' || provincia == ''
        || comune == '' || cap == '' || via == '' || cartaCredito.length != 16) {

        alert('mancano dei dati o il numero carta non è valido');
    }
    else {
        let data = await requestAnimationFrame('POST', '../ajax/registration.php',
            {
                nome: nome, cognome: cognome, email: email, username: username, password: password,
                cartaCredito: cartaCredito, regione: regione, provincia: provincia, comune: comune, cap: cap, via: via
            })

        alert(data['message']);

        if (data['status'] == 'success') {
            window.location.href = "../templates/login.php";
        }
    }
}