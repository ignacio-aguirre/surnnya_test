function status(caption){

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



function v_fecha(id,dias){

 valida_fecha(id);

 if(document.getElementById(id).value!=""){

  valor=document.getElementById(id).value;

  hoy=Date.now();

  ingresada=new Date(valor.substr(3,2)+"/"+valor.substr(0,2)+"/"+valor.substr(6,4))

  if((hoy-ingresada.getTime())/60000/60/24<0)document.getElementById(id).value="" ;

  if((hoy-ingresada.getTime())/60000/60/24>7)document.getElementById(id).value="" ;

 };

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


