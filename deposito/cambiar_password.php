<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Cambiar Contrase&ntilde;a";
include("encabezado.php"); 
?>
<div class="container" align="center">
<form class="form-inline" onsubmit="return false">
<div class="form-group has-warning">
<label class="label-form">Contrase&ntilde;a Actual</label>
<input class="form-control" id='anterior' type='password' size='20' maxlenght='20' onblur='valida_0(this.id)'>
</div><br><br>
<div class="form-group has-warning">
<label class="label-form">Nueva Contrase&ntilde;a</label>
<input class="form-control" id='nueva' type='password' size='20' maxlength='20' onblur='valida_0(this.id)'>
</div><br><br>
<div class="form-group has-warning">
<label class="label-form">Repetir Nueva Contrase&ntilde;a</label>
<input class="form-control" id='repeticion' type='password' size='20' maxlength='20' onblur='valida_0(this.id)'>
</div><br><br>
<button  class='btn btn-primary' id='Modi' onclick='modificar()'>Cambiar</button>
</form>
</div>

<script>
document.getElementById("anterior").focus();

function modificar(){
valida_0("anterior");
valida_0("nueva");
valida_0("repeticion");
ante=document.getElementById("anterior").value;
nuev=document.getElementById("nueva").value;
repe=document.getElementById("repeticion").value;
if(ejec("ej_sistema","PASSWORD","")!=ante) {
   alert("Contraseña Actual Incorrecta");
   document.getElementById("anterior").value="";
   document.getElementById("anterior").focus();
   return false;
};
if(nuev.length<4){
   status("Contraseña Nueva debe tener 4 caracteres mínimo");
   document.getElementById("nueva").value="";
   document.getElementById("nueva").focus();
   return false;
};
if(nuev!=repe){
   status("Las Contraseñas Ingresadas No Coinciden");
   document.getElementById("nueva").value="";
   document.getElementById("repeticion").value="";
   document.getElementById("nueva").focus();
   return false;
};
ejec("ej_sistema","PASSWORD_CAMBIA","&nueva="+nuev);
alert("la contraseña ha sido cambiada");
navega("salir");
}

</script>
</body>
</html>
