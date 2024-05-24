async function bloccaCarta(id){
    let data = await request('POST', '../ajax/bloccaCarta.php', {id:id});

    if(data['status']=='success'){
        alert(data['message']);
        window.location.reload();
    }
}