<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Apreciaci&oacute;n Profesional";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_profesional where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_profesional where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_profesional where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};

?>
</div>
<div class="container">
<p class="text-warning">
Explicitar la visi&oacute;n profesional acordada por el equipo.</p>
<form method="POST" action="profesional_do" onsubmit="return guardar()">
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
<strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Descripci&oacute;n: </li>
<textarea class="form-control" id="descripcion" name="descripcion" cols="90" rows="15" autofocus><?php echo $tri["descripcion"]?></textarea></li>
</ul>

<button class="btn-primary" id="aceptar" type="submit">Guardar Cambios</button>
</form>
</div>

<script>
function guardar(){
descripcion=document.getElementById("descripcion").value;
if(descripcion==""){status("Descripcion es un campo obligatorio");return false;};
if(confirm("Cancela para hacer modificaciones o revisar. Acepta para Guardar los datos.")){
return true;
};
return false;
}
</script>
</body>