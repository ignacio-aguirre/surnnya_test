<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Situaci&oacute;n de la Vida Cotidiana / Aspectos Convivenciales";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_convivencial where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_convivencial where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_convivencial where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};
?>
</div>
<div class="container">
<p class="text-warning">
Referenciar cu&aacute;les y c&oacute;mo son los v&iacute;nculos que el/la ni&ntilde;o/a o adolescente establece, con sus pares y con los adultos. 
Caracter&iacute;sticas de su participaci&oacute;n en espacios grupales y c&oacute;mo se desenvuelve de manera individual.
La idea es dar cuenta de su singularidad y de sus vivencias en la convivencia.
</p>
<form method="POST" action="convivencial_do" onsubmit="return guardar()">
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
if(descripcion==""){status("Campo Obligatorio");return false;};
if(confirm("Cancela para hacer modificaciones o revisar. Acepta para Guardar los datos.")){
return true;
};
return false;
}
</script>
</body>