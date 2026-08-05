<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Actividad de Usuarios";
include("encabezado.php");
?>
<div class="container">
<form class="form-inline" onsubmit="return false">
 <div class="form-group has-warning">
  <label class="label-form" for="desde">Desde</label>
  <input class="form-control" id='desde' size='8' maxlength='10' onblur='valida_fecha(this.id)' autofocus>
 </div>&nbsp;
 <div class="form-group has-warning">
  <label class="label-form" for="hasta">hasta</label>
  <input class="form-control" id='hasta' size='8' maxlength='10' onblur='valida_fecha(this.id)'>
  <button class='btn-primary' onclick='despliega_actividades()'>Consultar</button>
</div>
</form>
</div>

<div class="container">
<div class="table-responsive" id="tabla">
</div> 
</div> 
<script src='js/particulares.js'></script>
<script>
function despliega_actividades(){
   valida_fecha("desde");
   valida_fecha("hasta");
   dde=document.getElementById("desde").value; 	
   hta=document.getElementById("hasta").value; 	
   document.getElementById("tabla").innerHTML=ejec("browser_sistema","ACTIVIDADES","&desde="+dde+"&hasta="+hta);	
   return true;
}
</script>
</body>