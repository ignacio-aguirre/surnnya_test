<?php
include("Funciones.php"); 
session_start();
noconsulta();
$legajo="";
if(isset($_GET["legajo"])){
	$legajo=$_GET["legajo"];
};
$_SESSION['prestacion']="Nueva inclusi&oacute;n en el RUA";
include("encabezado-test.php");
?>
<div class="container">
	<form class="form" method="get" action="rua_nuevo_do" onsubmit="return valida()">
	<div class="form-group has-warning">
    <label class="label-form">B&uacute;squeda de NNYA</label>
	  <input id="busqueda" class="form-control" onblur="completa_apynom()" value="<?php echo $legajo?>" autofocus>
 	</div>
 	

<select class="form-control" id="legajos" onblur="pone_apynom()"></select>
 <div class="form-group has-warning">
    	<label class="label-form">Apellido y Nombre</label>
   		<var class="form-control" id="apynom"></var>
 	</div>
<input hidden name="legajo" id="legajo">
<div class="form-group has-warning">
    	<label class="label-form">Fecha ingreso al registro</label>
    	<input class="form-control" type="date" id="f_ingreso" name="f_ingreso" required>
 </div> 
<button class="btn-success">Procesar</button>
</form>
</div>
<script>
function completa_apynom(){
 if(document.getElementById("busqueda").value.length>3){
 resp=ejec_sq("sq_apynom2?frase="+document.getElementById("busqueda").value);
 document.getElementById("legajos").innerHTML=resp;
 document.getElementById("apynom").innerHTML="";
 document.getElementById("busqueda").value=""; 
}
}
function pone_apynom(){
 if(document.getElementById("legajos").options.length>0 ){
 	document.getElementById("legajo").value=legajos.value;
	x=document.getElementById("legajos").selectedIndex;
	texto=document.getElementById("legajos").options[x].text+" ("+document.getElementById("legajos").options[x].value+")";
   for(i=0;i<document.getElementById("legajos").options.length;i=0){
    document.getElementById("legajos").options.remove(0);
   };
	document.getElementById("apynom").innerHTML=texto;
	document.getElementById("busqueda").value="";

 };
}
function valida(){
	legajo=document.getElementById("legajo").value;
	
	if(legajo==""){
		status("No se encontr&oacute; legajo");return false;
	}
	return true;
}
</script>