function status(caption){

document.getElementById('enfocador').focus();

document.getElementById('stat_general').innerHTML=caption;



}



function semaforo_pone(){

id=ejec_sq("sq_sema_pone");

return id;

}

function nula(){
return true;
}


function semaforo_saca(id){

ejec_sq("sq_sema_saca?id_sema="+id);

};


function establece_anio(){

anio=document.getElementById("anio").value;

/*ejec("ej","ESTABLECE_ANIO","&anio="+anio);*/

return true;

}

function ejec_sq(url){

window.document.activeElement.style.cursor="progress";

    pet = new XMLHttpRequest();

    pet.open('GET', url, false);

    pet.send(null);

    var resp = pet.responseText;

window.document.activeElement.style.cursor="default";

    return resp;	

}

