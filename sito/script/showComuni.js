async function mostraRegioni() {

    $('#selectRegione').empty();
    addRegione('', 'Scegli regione');

    let data=await request('GET', '../ajax/getRegioni.php', {});
        
        for (let i = 0; i < data.length; i++) {
            addRegione(data[i]["codice_regione"], data[i]["denominazione_regione"]);
        }
    };


async function mostraProvince(codice) {

    $('#selectProvincia').empty();
    addProvincia('', 'Scegli provincia');
    let data=await request('GET', '../ajax/getProvince.php', { 'codice': codice });

        for (let i = 0; i < data.length; i++) {
            addProvincia(data[i]["sigla_provincia"], data[i]["denominazione_provincia"]);
        }
    };


async function mostraComuni(codice) {

    $('#selectComune').empty();
    addComune('', 'Scegli comune');
    let data=await request('GET', '../ajax/getComuni.php', { 'codice': codice });

        for (let i = 0; i < data.length; i++) {
            addComune(data[i]['cap'], data[i]["denominazione_ita"]);
        }
    };


function addRegione(id, nome) {

    if(nome=='Scegli regione')
        $('#selectRegione').append('<option value="" selected disabled>' + nome + '</option>');
    

    else
        $("#selectRegione").append('<option value=' + id + '>' + nome + '</option>');
}

function addProvincia(id, nome) {

    if(nome=='Scegli provincia')
        $('#selectProvincia').append('<option value="" selected disabled>' + nome + '</option>');
    
    else
        $("#selectProvincia").append('<option value=' + id + '>' + nome + '</option>');
}

function addComune(cap, nome) {

    if(nome=='Scegli comune')
        $('#selectComune').append('<option value="" selected disabled>' + nome + '</option>');
    
    else
        $("#selectComune").append('<option value=' + cap + '>' + nome + '</option>');
}
