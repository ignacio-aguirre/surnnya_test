<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Rubro Nuevo";
include("encabezado.php"); 
?>
<div class="container">
<form class="form" method="get" action="rubros_do" onsubmit="return valida()">
  <div class="form-group has-warning">
	<label class="label-form" for="descripcion">Descripci&oacute;n</label>
	<input class="form-control" id="descripcion" name="descripcion" maxlenght="100" onblur='valida_0(this.id)' autofocus required>
  </div>
  <input name="id" value="0" hidden>
  <button class="btn btn-primary">Guardar</button>	
</form>
<script>
function valida(){
  desc=document.getElementById("descripcion").value;
  if(desc!=""){
  id=ejec_sq("ej_tablas?tipo=RUBRO_CONS&descripcion="+desc);
  if(id>0){status("Rubro Existente");return false;};
  };
 return true;
}
</script>  
</div>
