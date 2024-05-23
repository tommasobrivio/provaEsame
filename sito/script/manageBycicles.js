async function showStations(data){

    $('#stazione').empty();

    $('#stazione').append('<option value="" selected disabled>Scegli la stazione</option>');
    let option='';

    data['message'].forEach(element => {
        option+='<option value="'+element['latitudine']+';'+element['longitudine']+'">'+element['via']+'</option>';
 
    });
    
    $('#stazione').append(option);
}

async function aggiungi(){
    let latitudine=$('#stazione').val().split(';')[0];
    let longitudine=$('#stazione').val().split(';')[1];
    let stato=$('#stato').val();

    if(latitudine!='' || longitudine!='' || stato!=''){
        let data= await request('POST', '../ajax/addBicycle.php', {lat:latitudine, lon:longitudine, stato:stato});

        if(data['status']=='success')
            window.location.reload();
    }
}

async function getBicycleId(id){

    let data = await request('POST', '../ajax/getBicycle.php', {id:id});

    $('#stato').val(data['message'][0]['stato']);
    $('#lat').val(data['message'][0]['latitudine']);
    $('#lon').val(data['message'][0]['longitudine']);
    $('#gps').val(data['message'][0]['gps']);
    $('#RFID').val(data['message'][0]['RFID']);

}

async function updateBicycle(id){
    var stato = $('#stato').val();
    var gps = $('#gps').val();
    var RFID = $('#RFID').val();

    let data = await request('POST', '../ajax/updateBicycle.php', {stato:stato, gps:gps, rfid:RFID, id:id});

    if(data['status']=='success'){
        window.location.href='../templates/bicycles.php';
    }
}