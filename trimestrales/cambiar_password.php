<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Cambiar Contrase&ntilde;a";
include("encabezado.php"); 
?>
</div>
<div class="container">
   <form class="form" onsubmit="return false">
      <div class="form-group has-warning">
         <label class="label-form" for="anterior">Contrase&ntilde;a Actual</label>
         <input class="form-control" id='anterior' type='password' size='20' maxlength='20' required>
      <div>   
         <br>
         <p class="text-warning">Requisitos para la nueva contrase&ntilde;a: una may&uacute;scula, una min&uacute;scula, un d&iacute;gito num&eacute;rico, un caracter entre #$().,;@-_ y un largo m&iacute;nimo de 8 carcateres</p>
         <br>
      <div class="form-group has-warning">
         <label class="label-form" for="nueva">Nueva Contrase&ntilde;a</label>
         <input class="form-control" id='nueva' type='password' size='20' maxlength='20' required>
      <div>
      <div class="form-group has-warning">
         <label class="label-form" for="repeticion">Repetir Nueva Contrase&ntilde;a</label>   
         <input class="form-control" id='repeticion' type='password' size='20' maxlength='20' required>
     </div>    
<button  class='btn-primary' id='Modi' onclick='modificar()'>Cambiar</button>
</div>

<script>
document.getElementById("anterior").focus();

function modificar(){
ante=document.getElementById("anterior").value;
nuev=document.getElementById("nueva").value;
repe=document.getElementById("repeticion").value;
if(ejec("ej_sistema","PASSWORD","")!=ante.toUpperCase()) {
	alert("Contrase&ntilde;a Actual Incorrecta");
   document.getElementById("anterior").value="";
   document.getElementById("anterior").focus();

   return false;

};

if(!robusta(nuev)){
   return false;
}

if(nuev!=repe){
   status("Las Passwords Ingresadas No Coinciden");
   document.getElementById("nueva").value="";
   document.getElementById("repeticion").value="";
   document.getElementById("nueva").focus();
   return false;

};

ejec("ej_sistema","PASSWORD_CAMBIA","&nueva="+nuev);

alert("la password ha sido cambiada");

navega("salir");

}

function robusta(t){
   if(t.length<8){
      status("longitud de nueva password es menor a 8");
      return false;
   }
   
   cnt_min=0;
   cnt_may=0;
   cnt_dig=0;
   cnt_esp=0;
   for(i=0;i<t.length;i++){
      c=t.substring(i,1);
      if("ABCDEFGHIJKLMNOPQRSTUVWXYZ".indexOf(c)!=-1){cnt_may++;};
      if("abcdefghijklmnopqrstuvwxyz".indexOf(c)!=-1){cnt_min++;};
      if("#$().,;@-_".indexOf(c)!=-1){cnt_esp++;};
      if("0123456789".indexOf(c)!=-1){cnt_dig++;};
   };
   if(cnt_min==0){status("sin min&uacute;sculas");return false;};
   if(cnt_may==0){status("sin mayu&uacute;sculas");return false;};
   if(cnt_dig==0){status("sin n&uacute;meros");return false;};
   if(cnt_esp==0){status("sin caracteres especiales permitidos");return false;};
   status("");
   return true;
}


</script>

</body>

</html>

