<?php 
include("funciones.php");
session_start();
$status="";
$_SESSION["prestacion"]="Men&uacute; Gestiones";
include("encabezado.php");

$dispositivo=$_SESSION["hogar"];
$sector=$_SESSION["sector"];
ejecute("update movil_gestiones left join movil_viajes on viaje=movil_viajes.id set movil_gestiones.estado='VEN' where 
	movil_gestiones.estado='SOL' and 
	(movil_viajes.fecha<curdate() or (movil_viajes.fecha=curdate() and movil_viajes.hora<curtime()))");
?>
</div>
<div class="container">


<div class="table-responsive col-md-6">
	<h4>Opciones disponibles</h4>
<table class="table col-md-6">
<tr class="info" onclick=location.href="mv_gestiones_ver"><td align="center">Gestiones en curso</td></tr>
<tr class="success" onclick=location.href="mv_viajes_cancelar"><td align="center">Cancelar viaje</td></tr>
<tr class="success" onclick=location.href="mv_programar?bloqueado=7691<?php echo intval($dispositivo+$sector)?>"><td align="center">Agregar viaje</td></tr>
<tr class="success" onclick=location.href="mv_programar?recreacion=7691<?php echo intval($dispositivo+$sector)?>"><td align="center">Agregar viaje minibus recreativo</td></tr-->


</table>
</div>



</div>
</body>