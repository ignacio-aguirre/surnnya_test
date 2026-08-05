<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Estrategias y Acciones";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_estrategias where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_estrategias where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_estrategias where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};

?>
</div>
<div class="container">
<form method="POST" action="estrategias_do" onsubmit="return guardar()">
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
<strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item"><strong>Estrategias y Acciones:</strong> </li>
<p class="text-warning">Indicar las acciones desarrolladas en base al plan de trabajo y las estrategias definidas para el cuidado y acompa&ntilde;amiento de 
el/la ni&ntilde;o/a o adolescente. En el caso de realizar acuerdos con los NNyA mencionarlos. Explicitar la visi&oacute;n profesional acordada por el equipo.</p>
<textarea class="form-control" id="estraccion" name="estraccion" cols="90" rows="15" autofocus required><?php echo $tri["estraccion"]?></textarea></li>
<li class="list-group-item"><strong>Articulaci&oacute;n con Efectores:</strong> </li>
<p class="text-warning">Mencionar las instancias de articulaci&oacute;n con otros, identificando fecha y acuerdos resultantes. Por ejemplo: Audiencia con fecha xx/xx donde se acuerda...,
 reuni&oacute;n con equipo... comunicaci&oacute;n telef&oacute;nica donde se acuerda...</p>
<textarea class="form-control" id="articulacion" name="articulacion" cols="90" rows="15" required><?php echo $tri["articulacion"]?></textarea></li>
</ul>

<button class="btn-primary" id="aceptar" type="submit">Guardar Cambios</button>
</form>
</div>

<script>
function guardar(){
de1=document.getElementById("estraccion").value;
de2=document.getElementById("articulacion").value;
if($de1==""||$de2==""){status("Ambos campos son obligatorios");return false;};
if(confirm("Cancela para hacer modificaciones o revisar. Acepta para Guardar los datos.")){
return true;
};
return false;
}
</script>
</body>