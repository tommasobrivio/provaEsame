async function visualizzaCarteBloccate(){
    let data = await request('POST', '../ajax/getCarteBloccate.php', {});

    let table='';
    if(data['status']='success'){
        data['message'].forEach(element => {
            
            table += "<tr><td>" + element['ID'] + "</td>" +
                    "<td>" + element['username'] + "</td><td>" + element['nome'] + "</td>" +
                    "<td>" + element['cognome'] + "</td><td>" + element['numeroTessera'] + "</td>"+
                    "<td><button onclick='rigeneraTessera(" + element["ID"] + ")' class='rigenera btn btn-dark'>RIGENERA TESSERA</button></td></tr>";
     
        });

        $('#utentiBloccati').append(table);
    }
}


async function rigeneraTessera(id){

    let data=await request('POST', '../ajax/rigeneraTessera.php', {id:id});

    if(data['status']=='success'){
        alert(data['message']);

        window.location.reload();
    }
}