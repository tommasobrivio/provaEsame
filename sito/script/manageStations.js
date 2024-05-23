async function aggiungi() {

    var slot = $('#slot').val();
    var regione = $('#selectRegione').val();
    var provincia = $('#selectProvincia').val();
    var comune = $('#selectComune').val();
    var cap = $('#cap').val();
    var via = $('#via').val();

    if (slot == '' || slot < 0 || regione == '' || provincia == ''
        || comune == '' || cap == '' || via == '') {

        alert('mancano dei dati');
    }
    else {

        let data=await request('POST', '../ajax/addStation.php', {slot: slot, regione: regione, provincia: provincia, comune: comune, cap: cap, via: via})
        
        if (data['status'] == 'success') {
            console.log('d')
            return true;
        }
        return false;
    }
}

async function setLatLon(){

    let data = await request('POST', '../ajax/getStations.php', {last:true})

    let address= data['message'][0]['via']+','+data['message'][0]['citta']+','+data['message'][0]['provincia']+','+data['message'][0]['regione']+',Italy';
    let url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);

    let lat, lon;
    await $.getJSON(url, function (data1) {
        if (data1.length > 0) {
            lat = parseFloat(data1[0].lat);
            lon = parseFloat(data1[0].lon);
        }
    });

    let data1= await request('POST', '../ajax/setLatLon.php', {lat:lat, lon:lon, id:data['message'][0]['codice']});
    
    console.log(data1);
}

async function getStazioneCodice(codice){

    let data = await request('POST', '../ajax/getStations.php', {codice:codice});

    $('#slot').val(data['message'][0]['slot']);
    $('#regione').val(data['message'][0]['regione']);
    $('#provincia').val(data['message'][0]['provincia']);
    $('#comune').val(data['message'][0]['citta']);
    $('#cap').val(data['message'][0]['cap']);
    $('#via').val(data['message'][0]['via']);

}

async function updateSlot(codice){
    var slot = $('#slot').val();

    let data = await request('POST', '../ajax/updateStation.php', {slot:slot, codice:codice});

    if(data['status'=='success']){
        window.location.href='../templates/stations.php';
    }
}