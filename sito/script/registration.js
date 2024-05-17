function mostraRegioni() {

    $('#selectRegione').empty();
    addRegione('', 'Scegli regione');
    $.get('../ajax/getRegioni.php', {}, function (data) {
        for (let i = 0; i < data.length; i++) {
            addRegione(data[i]["codice_regione"], data[i]["denominazione_regione"]);
        }
    });
}

function mostraProvince(codice) {

    $('#selectProvincia').empty();
    addProvincia('', 'Scegli provincia');
    $.get('../ajax/getProvince.php', { 'codice': codice }, function (data) {

        console.log(data)

        for (let i = 0; i < data.length; i++) {
            addProvincia(data[i]["sigla_provincia"], data[i]["denominazione_provincia"]);
        }
    });
}

function mostraComuni(codice) {

    $('#selectComune').empty();
    addComune('', 'Scegli comune');
    $.get('../ajax/getComuni.php', { 'codice': codice }, function (data) {

        for (let i = 0; i < data.length; i++) {
            addComune(data[i]["denominazione_ita"]);
        }
    });
}

function addRegione(id, nome) {

    if(nome=='Scegli regione')
        $('#selectRegione').append('<option value="' + id + '" selected disabled>' + nome + '</option>');
    

    else
        $("#selectRegione").append('<option value=' + id + '>' + nome + '</option>');
}

function addProvincia(id, nome) {

    if(nome=='Scegli provincia')
        $('#selectProvincia').append('<option value="' + id + '" selected disabled>' + nome + '</option>');
    
    else
        $("#selectProvincia").append('<option value=' + id + '>' + nome + '</option>');
}

function addComune(nome) {

    if(nome=='Scegli comune')
        $('#selectComune').append('<option value="' + id + '" selected disabled>' + nome + '</option>');
    
    else
        $("#selectComune").append('<option value=' + nome + '>' + nome + '</option>');
}

function registra(){

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

    if(nome=='' || cognome=='' || email=='' || username=='' || password=='' || cartaCredito=='' || regione=='' || provincia=='' 
        || comune=='' || cap=='' || via=='') {  

            alert('mancano dei dati');
    }
    else {
        $.post('../ajax/registration.php', {nome:nome, cognome:cognome, email:email, username:username, password:password, 
            cartaCredito:cartaCredito, regione:regione, provincia:provincia, comune:comune, cap:cap, via:via}, function(data){
                
                alert(data['message']);

                if(data['status']=='success'){
                    window.location.href="../templates/home.php";
                }
        })
    }

}