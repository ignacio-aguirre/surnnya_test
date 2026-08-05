<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Consulta Ingreso de Bienes al Dep&oacute;sito";
include("encabezado.php"); 
?>
<div class="container">
<form class="form-inline" onsubmit="return false">
 <div class="form-group has-warning">
  <label class="label-form" for="desde">Desde</label>
  <input class="form-control" id='desde' size='8' maxlength='10' onblur='valida_fecha(this.id)' required autofocus>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="hasta">Hasta</label>
  <input class="form-control" id='hasta' size='8' maxlength='10' onblur='valida_fecha(this.id)' required>
 </div>
 <button class='btn-primary' onclick='despliega_ingresos()'>Consultar</button>
 <button class='btn-success' id='excel' onclick='navega("browser_ingresos?tipo=INGRESOS_EXCEL")'>Excel</button> 
</form>
</div>
<div class="container">
<div class="table-responsive pre-scrollable" id="tabla">
</div> 
</div> 
</div>
</div>
<script>
function despliega_ingresos(){
    valida_fecha("desde");
    valida_fecha("hasta");
    dde=document.getElementById("desde").value;
    hta=document.getElementById("hasta").value;
    if(fsql(dde)>fsql(hta)) {alert("Fecha desde debe ser menor o igual que fecha hasta"); return false;}
    document.getElementById("tabla").innerHTML=ejec("browser_ingresos","INGRESOS","&desde="+dde+"&hasta="+hta);
    return true;
}


function ver(id){
 navega("ingreso_ver?id="+id);
}
</script>
</body>