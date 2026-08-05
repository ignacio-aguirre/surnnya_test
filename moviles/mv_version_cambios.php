<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Historial de cambios en versiones del sistema";
include("encabezado.php");
$log=registros("select * from surnnya.versiones_cambios where modulo='MOVILES' order by fecha desc, id desc");?>
<div class="container">
	<div class="table-responsive pre-scrollable">
	<table class="table">
	<tr class="bg-primary"><th>Versi&oacute;n</th><th>Fecha</th><th>Cambios</th></tr>	
	<?php
	while($l=mysqli_fetch_assoc($log)){
		echo "<tr><td>".$l["entorno"].": ".$l["ver_1"].".".$l["ver_2"].".".$l["ver_3"]."</td><td>".ffec($l["fecha"]).
		"</td><td>".nl2br($l["log_cambios"])."</td></tr>";

	};
?>
</table></div>
</div>