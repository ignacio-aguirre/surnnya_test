<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Situaci&oacute;n al Ingreso";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_ingreso where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_ingreso where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_ingreso where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};
?>
</div>
<div class="container">
<p class="text-warning">
Se debe consignar: motivo de ingreso, procedencia, permanencia o no en otro dispositivo previo, organismo derivante, situaci&oacute;n en la que se encontraba al momento del ingreso.
 Informaci&oacute;n que se construye a partir de los informes previos y se va ampliando con aquellos datos que se van obteniendo en el primer per&iacute;odo de alojamiento.
</p>
<form method="POST" action="ingreso_do" onsubmit="return guardar()">
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
<strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Descripci&oacute;n: </li>
<textarea class="form-control" id="descripcion" name="descripcion" cols="90" rows="15" required autofocus><?php echo $tri["descripcion"]?></textarea></li>
</ul>

<button class="btn-primary" id="aceptar" type="submit">Guardar Cambios</button>
</form>
</div>

<script>
function guardar(){
descripcion=document.getElementById("descripcion").value;
if(descripcion==""){status("Campo Obligatorio");return false;};
if(confirm("Cancela para hacer modificaciones o revisar. Acepta para Guardar los datos.")){
return true;
};
return false;
}
</script>
</body>