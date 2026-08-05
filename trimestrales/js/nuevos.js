
function iniciar(){
var myVar=setInterval(function(){myTimer()},1000);    
    
}

function Navegador() {
  var is_chrome= navigator.userAgent.toLowerCase().indexOf('chrome/') > -1;
  var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox/') > -1;
  var is_ie = navigator.userAgent.toLowerCase().indexOf('msie ') > -1;
  var Nav="";
        //Detectando si es Chrome
 if (is_chrome ) {
            var posicion = navigator.userAgent.toLowerCase().indexOf('chrome/');
            var ver_chrome = navigator.userAgent.toLowerCase().substring(posicion+7, posicion+11);
            //Comprobar version
            ver_chrome = parseFloat(ver_chrome);
            Nav='Google Chrome, Version: ' + ver_chrome;
        };
 
        //Detectando si es Firefox
        if (is_firefox ) {
            var posicion = navigator.userAgent.toLowerCase().lastIndexOf('firefox/');
            var ver_firefox = navigator.userAgent.toLowerCase().substring(posicion+8, posicion+12);
            //Comprobar version
            ver_firefox = parseFloat(ver_firefox); 
            Nav='Firefox, Version: ' + ver_firefox;
        };
 
        //Detectando Cualquier version de IE
        if (is_ie ) {
            var posicion = navigator.userAgent.toLowerCase().lastIndexOf('msie ');
            var ver_ie = navigator.userAgent.toLowerCase().substring(posicion+5, posicion+8);
            //Comprobar version
            ver_ie = parseFloat(ver_ie);
            Nav='Internet Explorer, Version: ' + ver_ie;
        };
   return(Nav);
};


function enfoca(x){
document.getElementById(x).focus();
};

function navega(vurl){
window.location.href = vurl};

function naveganuevo(vurl){
window.open(vurl,'_blank');};

function seleccionar(x,valor) {
var y=document.getElementById(x).options;
var cosa=document.getElementById(x);
for (i=0;i<y.length;i++)
{
if(y[i].value==valor) cosa.selectedIndex=i};
};

function seleccionarn(x,valor) {
var y=document.getElementById(x).options;
var cosa=document.getElementById(x);
for (i=0;i<y.length;i++)
{
if(y[i].text==valor) cosa.selectedIndex=i};
};

function valida_1(x) {
cosa=document.getElementById(x);
var texto=cosa.value.toUpperCase();
texto=trim(texto);
while (texto.indexOf("'")>-1) texto=texto.replace("'",'"');
texto=texto.replace("'",'"');
cosa.value=texto;
if (texto.length==0)  {cosa.value="COMPLETAR";};
};

function valida_0(x) {
cosa=document.getElementById(x);
var texto=cosa.value.toUpperCase();
texto=trim(texto);
while (texto.indexOf("'")>-1) texto=texto.replace("'",'"');
cosa.value=texto;
};

function valida_2(x) {
cosa=document.getElementById(x);
var texto=cosa.value;
texto=trim(texto);
while (texto.indexOf("'")>-1) texto=texto.replace("'",'"');
cosa.value=texto;
}

function valida_mail(x) {
cosa=document.getElementById(x);
var texto=cosa.value;
texto=trim(texto);
while (texto.indexOf("'")>-1) texto=texto.replace("'",'"');
if (texto.indexOf("@")==-1)  {texto="";};
if (texto.indexOf(".")<2)  {cosa.value="";};
cosa.value=texto;
};

function valida_entero(x) {
cosa=document.getElementById(x);
var texto=parseInt(cosa.value);
if (isNaN(texto)) texto="";
cosa.value=texto;
};

function valida_dec(x) {
cosa=document.getElementById(x);
var texto=parseFloat(cosa.value);
if (isNaN(texto)) texto="";
cosa.value=texto;
};

function validaCuit(id) 
{ 
    var aMult   = '6789456789'; 
    var aMult   = aMult.split(''); 
    var sCUIT   = String(document.getElementById(id).value); 
   
    var iResult = 0; 
    var aCUIT = sCUIT.split(''); 
     
    if (aCUIT.length == 11) 
    { 
        // La suma de los productos 
        for(var i = 0; i <= 9; i++) 
        { 
            iResult += aCUIT[i] * aMult[i]; 
        } 
        // El módulo de 11 
        iResult = (iResult % 11); 
         
        // Se compara el resultado con el dígito verificador 
        if(iResult != aCUIT[10]) {alert("cuil/cuit incorrecta.");document.getElementById(id).value="" ;return false;} else return true;    
   }; 
   {alert("longitud de cuit/cuil incorrecta."); document.getElementById(id).value="";return false;}; 
}

function trim (myString){
return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
};

function der(str,l) {
var ini=str.length-l;
return str.substr(ini,l);
};

function izq(str,l) {
return str.substr(0,l);
}

function ceros(n) {
return der("00"+n,2);
};

function llena_fecha(x) {
cosa=document.getElementById(x);
var f = new Date();
cosa.value=ceros(f.getDate(),2) + "/" + ceros((f.getMonth() +1),2) + "/" + f.getFullYear();
};

function hoy(){
var f = new Date();
return ceros(f.getDate(),2) + "/" + ceros((f.getMonth() +1),2) + "/" + f.getFullYear();
};

function fvalida(d,m,a) {
dia=parseInt(d);
mes=parseInt(m);
ano=parseInt(a);
if(isNaN(dia)||isNaN(mes)||isNaN(ano)) return false;
if(ano<1940||ano>2040||mes<1||mes>12||dia<1||dia>31) return false;
if (dia==31 && (mes==2||mes==4||mes==6||mes==9||mes==11)) return false;
if (dia==30 && mes==2) return false;
if (dia==29 && mes==2 && !bisiesto(ano)) return false;
return true;
};

function bisiesto(anio) {
if (!((anio%4)==0) || ((anio%100)==0)) return false ;
return true;
};

function valida_fecha(x, vacio) {
var vac=(vacio||0);
cosa=document.getElementById(x);
var texto=cosa.value;
var f = new Date();

if (!(texto.length==10)) { 
   if((texto.length==2) && (fvalida(texto.substr(0,2),f.getMonth()+1,f.getFullYear()))) {cosa.value=texto.substr(0,2) + "/" + ceros((f.getMonth() +1),2) + "/" + f.getFullYear();} 
   else if((texto.length==4)  && (fvalida(texto.substr(0,2),texto.substr(2,2),f.getFullYear())))  {cosa.value=texto.substr(0,2) + "/" + texto.substr(2,2) + "/" + f.getFullYear();} 
   else if((texto.length==5)  && (fvalida(texto.substr(0,2),texto.substr(3,2),f.getFullYear())))  {cosa.value=texto.substr(0,2) + "/" + texto.substr(3,2) + "/" + f.getFullYear();} 
   else if((texto.length==6) && (fvalida(texto.substr(0,2),texto.substr(2,2),"20" + texto.substr(4,2))) && (texto.substr(4,2)<="20"))  {cosa.value=texto.substr(0,2) + "/" + texto.substr(2,2) + "/" + "20" + texto.substr(4,2);} 
   else if((texto.length==6) && (fvalida(texto.substr(0,2),texto.substr(2,2),"19" + texto.substr(4,2))) && (texto.substr(4,2)>"20"))  {cosa.value=texto.substr(0,2) + "/" + texto.substr(2,2) + "/" + "19" + texto.substr(4,2);} 
   else if((texto.length==8) && fvalida(texto.substr(0,2),texto.substr(2,2), texto.substr(4,4)))  {cosa.value=texto.substr(0,2) + "/" + texto.substr(2,2) + "/" + texto.substr(4,4);} 
   else if((texto.length==8) && fvalida(texto.substr(0,2),texto.substr(3,2), "20"+texto.substr(6,2)))  {cosa.value=texto.substr(0,6) + "20" + texto.substr(6,2) ;} 
   else if(vac==1) cosa.value=""
   else	llena_fecha(x);
	};
if (texto.length==10) {
	texto=texto.substr(0,2)+ "/" +texto.substr(3,2)+ "/" +texto.substr(6,4);
	for (var ind=0; ind<texto.length; ind++) { if((ind!=2) && (ind!=5) && (texto.substr(ind,1)>"9"|texto.substr(ind,1)<"0")) texto=izq(texto,ind)+"0"+texto.substr(ind+1);};
        cosa.value=texto;
	if(!fvalida(texto.substr(0,2),texto.substr(3,2),der(texto,4))) llena_fecha(x);
	};
};


function edadApx(e,f) {
var hoy= new Date();
var fe=String(f);
var ani=izq(fe,4);
var dia=der(fe,2);
var mes=fe.substr(4,2);
var difa=hoy.getFullYear()-ani;
var cumplio=0;
if(mes<hoy.getMonth()+1) cumplio=1;
if(mes==hoy.getMonth()+1&&dia<=hoy.getDate()) cumplio=1;
document.write(difa+cumplio-1+e);

};

function limite(x,largo,aviso) {
cosa=document.getElementById(x);
avis=document.getElementById(aviso);
avis.value=cosa.value.length
if (cosa.value.length>largo) {
cosa.value=izq(cosa.value,largo);
cosa.focus();
};
};

function reempla(texto) {
resu=resu.replace(/á/g,"&aacute;");
resu=resu.replace(/é/g,"&eacute;");
resu=resu.replace(/í/g,"&iacute;");
resu=resu.replace(/ó/g,"&oacute;");
resu=resu.replace(/ú/g,"&uacute;");
return resu;
};

function myTimer(){
var ofh=document.getElementById("enfocador");
ofh.innerHTML=String(ocurre);
ocurre=ocurre-1;
if(ocurre<1) navega("sesion_expirada.php");
};


function valida_hora(x){
 texto=document.getElementById(x).value;
 largo=texto.length;
 if(largo!=8 && largo!=6 && largo!=5 && largo!=4 && largo!=2) {document.getElementById(x).value="";return false;};
 if(largo==2) texto=texto + ":00:00";
 if(largo==4) texto.substr(0,2)+ ":" +texto.substr(2,2) + ":00";
 if(largo==5)  texto=texto + ":00";
 if(largo==6)  texto.substr(0,2)+ ":" +texto.substr(2,2) + ":" + texto.substr(2,2);
 if(texto.substr(0,2)<"00" || texto.substr(0,2)>"23") {document.getElementById(x).value="";return false;};
 if(texto.substr(3,2)<"00" || texto.substr(3,2)>"59") {document.getElementById(x).value="";return false;};
 if(texto.substr(6,2)<"00" || texto.substr(6,2)>"59") {document.getElementById(x).value="";return false;};
 document.getElementById(x).value=texto;
}

function parsear(respuesta){
 if (window.DOMParser)
  {
   parser=new DOMParser();
   return parser.parseFromString(respuesta,"text/xml");
  }
 else // Internet Explorer
  {
   xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
   xmlDoc.async=false;
   return xmlDoc.loadXML(respuesta);
  };
 return false;
}

function fsql(fecha){
 return der(fecha,4)+fecha.substr(3,2)+izq(fecha,2);
}


function ffec(fecha){
 return der(fecha,2)+"/"+fecha.substr(5,2)+"/"+izq(fecha,4);
}

function ejec(url,tipo,parametros){
window.document.activeElement.style.cursor="progress";
    url=url+"?tipo="+tipo+parametros;
    pet = new XMLHttpRequest();
    pet.open('GET', url, false);
    pet.send(null);
    var resp = pet.responseText;
window.document.activeElement.style.cursor="default";
    return resp;	
}
function eje(url){
    pet = new XMLHttpRequest();
    pet.open('GET', url, false);
    pet.send(null);
    var resp = pet.responseText;
    return resp;	
}


function exhibe_d_h(desde,hasta,pasos){
   tabla=document.getElementById("brow");
   for(i=1;i<tabla.rows.length;i++){
       
    tabla.rows[i].style.visibility ="collapse";
     if(desde<=i&&i<=hasta) tabla.rows[i].style.visibility ="visible";
    }   
  document.getElementById("mas").disabled=true;
  document.getElementById("menos").disabled=true;
  tabla.resize;
  if(hasta+1<tabla.rows.length) {document.getElementById("mas").disabled=false;
   document.getElementById("mas").setAttribute('onclick',"exhibe_d_h("+String(hasta+1)+","+String(hasta+pasos)+","+pasos+")");};
  if(desde>1) {document.getElementById("menos").disabled=false;
   document.getElementById("menos").setAttribute('onclick',"exhibe_d_h("+String(desde-pasos)+","+String(desde-1)+","+pasos+")");};
}

function status(caption){
document.getElementById('stat_general').innerHTML=caption;
if(caption!=""){
    var snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");  
    snd.play();
};

}

function semaforo_pone(){
id=ejec("ej_sistema","SEMA_PONE","");
while(ejec("ej_sistema","SEMA_CONSULTA","&id="+id)!=id){
 if(ejec("ej_sistema","SEMA_VIGENTE","&id="+id)!=id) id=ejec("ej_sistema","SEMA_PONE","");
};
return id;
}

function semaforo_saca(id){
ejec("ej_sistema","SEMA_SACA","&id="+id);
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