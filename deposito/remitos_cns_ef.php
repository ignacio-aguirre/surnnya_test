<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Consulta Entregas por Efector";
include("encabezado.php"); 
?>

<div class="container">
<form class="form-inline" onsubmit='return false'>
 <div class="form-group has-warning">
  <label class="label-form" for="desde">Desde</label>
  <input class="form-control" size='8' maxlength='10' id='desde'  value='<?php echo "01".substr($_SESSION["hoy"],2)?>' onblur='valida_fecha(this.id)'>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="hasta">Hasta</label>
  <input class="form-control" size='8' maxlength='10' id='hasta' value='<?php echo $_SESSION["hoy"]?>' onblur='valida_fecha(this.id)'>
 </div>
 <button class='btn btn-success' onclick='aexcel()'>Excel</button>
</form>
</div>
<script>
function aexcel(){
  valida_fecha("desde");
  valida_fecha("hasta");
	
  desde=document.getElementById("desde").value;
  hasta=document.getElementById("hasta").value;
  navega("remitos_cns_ef_excel?desde="+desde+"&hasta="+hasta);
}
</script>

