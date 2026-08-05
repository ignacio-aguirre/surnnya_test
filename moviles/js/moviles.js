function salealo(i){
 obje=document.getElementById("p"+i);
 oleg=document.getElementById("lega"+i);

 if(obje.value==""){
    oleg.value="";

 }else{buscapi(i,0)};
 recuentoalo();
}

function buscapi(i,dispositivo){
 obje=document.getElementById("p"+i);
 oleg=document.getElementById("lega"+i);

 if (obje.value.length>4){
  var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
  status("");
        resp = xhttp.responseText;
        var objeto = JSON.parse(resp);
       
        if(typeof objeto.errorMessage!="undefined"){return false;}
        else if(typeof objeto.apellidos!="undefined"){
             obje.value=objeto.apellidos+", "+objeto.nombres;
       oleg.value=objeto.legajo;

        };

        };
  };
  xhttp.open("GET", "l_mv_alojados?dispositivo="+dispositivo+"&texto="+obje.value, false);
  xhttp.send();
 };  
return true; 
}

function saleadu(i){
 obje=document.getElementById("a"+i);
 ocel=document.getElementById("acel"+i);
 if(obje.value==""){
     ocel.value="";}
 else{
    if(obje.value=="ad"){
    obje.value="Adulto a designar";
    ocel.value="1100000000";

    } else{
    buscaad(i);
   }
 };
  recuentoadu();
}

function buscaad(i){
 obje=document.getElementById("a"+i);
 ocel=document.getElementById("acel"+i);

 if (obje.value.length>4){
  var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
  status("");
        resp = xhttp.responseText;
        var objeto = JSON.parse(resp);
       
        if(typeof objeto.errorMessage!="undefined"){return false;}
        else if(typeof objeto.apellido!="undefined"){
             obje.value=objeto.apellido+", "+objeto.nombre;
             ocel.value=objeto.celular;

        };

        };
  };
  xhttp.open("GET", "l_mv_adultos?texto="+obje.value, false);
  xhttp.send();
 };
 
   
return true; 
} 

function seleccional(){
  obj=document.getElementById("lista_alojados");
  t=obj.options[obj.selectedIndex].text;
  l=obj.value;
  const col_alo=document.getElementsByClassName("form-control alo");
  
  for(i=0;i<col_alo.length;i++){
    ida=col_alo[i].id;
    idl="lega"+der(ida,ida.length-1);
    
    if(col_alo[i].value==""){
    
      
      col_alo[i].value=t;
      
      document.getElementById(idl).value=l;
      recuentoalo();
      break;
    };
    if(document.getElementById(idl).value==l){
      status("alojado repetido");
      recuentoalo();
      break;
    };
  }
}

function seleccionad(){
    obj=document.getElementById("lista_adultos");
    t=obj.options[obj.selectedIndex].text;
    l=obj.value;
    const col_adu=document.getElementsByClassName("form-control adu");
    for(i=0;i<col_adu.length;i++){
    
    ida=col_adu[i].id;
    idc="acel"+der(ida,ida.length-1);
    
    if(col_adu[i].value==""){
    
      col_adu[i].value=t;

      document.getElementById(idc).value=l;
      recuentoadu();
      break;
    };
    if(document.getElementById(idc).value==l){
      status("adulto repetido");
      recuentoadu();
      break;
    };
  }
}
function recuentoalo(){
    cnt_pas_alo=0;
 const col_alo=document.getElementsByClassName("form-control alo");
   for(i=0;i<col_alo.length;i++){
    ida=col_alo[i].id;
    idl="lega"+der(ida,ida.length-1);
    if(document.getElementById(idl).value!=""){cnt_pas_alo++;};
};
document.getElementById("pasajeros_alojados").value=cnt_pas_alo;
return true;
}

function recuentoadu(){
const col_adu=document.getElementsByClassName("form-control adu");
    cnt_pas_adu=0;
    for(i=0;i<col_adu.length;i++){
     ida=col_adu[i].id;
     idc="acel"+der(ida,ida.length-1);
     if(document.getElementById(idc).value!=""){cnt_pas_adu++;};
};     
document.getElementById("pasajeros_acompaniantes").value=cnt_pas_adu;
return true;     
}

function nuevoadulto(){
    dispositivo=document.getElementById("dispositivo").value;
    ventana=window.open("mv_adulto_nuevo?dispositivo="+dispositivo);
    
}
