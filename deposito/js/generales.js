function enfoca(x){

document.getElementById(x).focus();

};



function navega(vurl){

window.location.href = vurl};




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




function valida_0(x) {

cosa=document.getElementById(x);

var texto=cosa.value.toUpperCase();

texto=trim(texto);

while (texto.indexOf("'")>-1) texto=texto.replace("'",'"');

cosa.value=texto;

};



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

if(ano<1930||ano>2030||mes<1||mes>12||dia<1||dia>31) return false;

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





function limite(x,largo,aviso) {

cosa=document.getElementById(x);

avis=document.getElementById(aviso);

avis.value=cosa.value.length

if (cosa.value.length>largo) {

cosa.value=izq(cosa.value,largo);

cosa.focus();

};

};





function myTimer(){

var ofh=document.getElementById("fechahora");

var d=new Date();

var t=d.toLocaleString();

ofh.innerHTML=t+" "+String(ocurre);

ocurre=ocurre-1;

if(ocurre<1) navega("salir.php");

};





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

//window.document.activeElement.style.cursor="progress";

    url=url+"?tipo="+tipo+parametros;

    pet = new XMLHttpRequest();

    pet.open('GET', url, false);

    pet.send(null);

    var resp = pet.responseText;

//window.document.activeElement.style.cursor="default";

    return resp;	

}





